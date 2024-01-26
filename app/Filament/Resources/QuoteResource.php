<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuoteResource\Pages;
use App\Filament\Resources\QuoteResource\RelationManagers;
use App\Models\Product;
use App\Models\Project;
use App\Models\Quote;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Quotation';
    protected static ?string $modelLabel = 'Quotations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('project_id')
                            ->searchable()
                            ->relationship('project')
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn(Project $record) => $record->project_name)
                            ->searchable(['project_name'])
                            ->default(request()->has('project_id') ? request()->get('project_id') : null)
                            ->required(),
                    ]),
                Section::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Repeater::make('quoteProducts')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->disableOptionWhen(function ($value, $state, Get $get) {
                                        return collect($get('../*.product_id'))
                                            ->reject(fn ($id) => $id == $state)
                                            ->filter()
                                            ->contains($value);
                                    })
                                    ->native(false)
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, $livewire) {
                                        $set('price', Product::find($get('product_id'))->price);
                                        self::updateTotals($get, $livewire);
                                    })
                                    ->required(),
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, $livewire) {
                                        self::updateTotals($get, $livewire);
                                    })
                                    ->prefix('Rp. '),
                                Forms\Components\TextInput::make('quantity')
                                    ->integer()
                                    ->default(1)
                                    ->required()
                                    ->live()
                            ])
                            ->live()
                            ->afterStateUpdated(function (Get $get, $livewire) {
                                self::updateTotals($get, $livewire);
                            })
                            ->afterStateHydrated(function (Get $get, $livewire) {
                                self::updateTotals($get, $livewire);
                            })
                            ->deleteAction(
                                fn (Action $action) => $action->after(fn (Get $get, $livewire) => self::updateTotals($get, $livewire)),
                            )
                            ->reorderable(false)
                            ->columns(3)
                    ]),
                Section::make()
                    ->columns(1)
                    ->maxWidth('1/2')
                    ->schema([
                        Forms\Components\TextInput::make('discount')
                            ->suffix('%')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->live(true)
                            ->afterStateUpdated(function (Get $get, $livewire) {
                                self::updateTotals($get, $livewire);
                            }),
                        Forms\Components\TextInput::make('sub_total')
                            ->numeric()
                            ->readOnly()
                            ->prefix('Rp.')
                            ->afterStateUpdated(function (Get $get, $livewire) {
                                self::updateTotals($get, $livewire);
                            }),
                        Forms\Components\TextInput::make('taxes')
                            ->suffix('%')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->live(true)
                            ->afterStateUpdated(function (Get $get, $livewire) {
                                self::updateTotals($get, $livewire);
                            }),
                        Forms\Components\TextInput::make('total')
                            ->numeric()
                            ->readOnly()
                            ->prefix('Rp.')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                if (!$user->hasRole(['Super Admin', 'Admin'])) {
                    $userId = $user->id;
                    $query->where(function ($query) use ($userId, $user) {
                        $query->whereHas('project', function ($userQuery) use ($userId) {
                            $userQuery->where('id', $userId);
                        });
                    });
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('project.project_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project.customer.customer_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('taxes')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotes::route('/'),
            'create' => Pages\CreateQuote::route('/create'),
            'edit' => Pages\EditQuote::route('/{record}/edit'),
        ];
    }

    public static function updateTotals(Get $get, $livewire): void
    {
        // Retrieve the state path of the form. Most likely, it's `data` but could be something else.
        $statePath = $livewire->getFormStatePath();


        $products = data_get($livewire, $statePath . '.quoteProducts');
        if (collect($products)->isEmpty()) {
            return;
        }
        $selectedProducts = collect($products)->filter(fn ($item) => !empty($item['product_id']) && !empty($item['quantity']));

        $prices = collect($products)->pluck('price', 'product_id');

        $subtotal = $selectedProducts->reduce(function ($subtotal, $product) use ($prices) {
            return $subtotal + ($prices[$product['product_id']] * $product['quantity']);
        }, 0);

        $x_sub = $subtotal - ($subtotal * (data_get($livewire, $statePath . '.discount') / 100));
        data_set($livewire, $statePath . '.sub_total', number_format($x_sub, 0, '.', ''));
        data_set($livewire, $statePath . '.total', number_format($x_sub + ($x_sub * (data_get($livewire, $statePath . '.taxes') / 100)), 0, '.', ''));
    }
}
