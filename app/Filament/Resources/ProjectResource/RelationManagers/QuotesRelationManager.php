<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectActual;
use App\Models\Quote;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuotesRelationManager extends RelationManager
{
    protected static string $relationship = 'quotes';

    public function form(Form $form): Form
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
                            ->default(10)
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('')
            ->columns([
                Tables\Columns\IconColumn::make('is_complete')
                    ->boolean()
                    ->label('Deal'),
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('Deal')
//                    ->hidden(fn($record) => $record->is_complete)
                    ->hidden(function (Quote $quote) {
                        $project = Project::find($quote->project_id);
                        if ($project->quotes()->where('is_complete',1)->count() !== 0 ){
                            return true;
                        }else{
                            return false;
                        }
                    })
                    ->icon('heroicon-m-pencil-square')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\DatePicker::make('date_deal')
                        ->label('Tanggal Deal')
                        ->required(),
                        Forms\Components\MarkdownEditor::make('note')
                    ])
                    ->action(function (Quote $quote, array $data): void {
                        $quote->update([
                            'is_complete' => true
                        ]);
                        $project = Project::find($quote->project_id);
                        $project->update([
                            'end_date' => $data['date_deal'],
                            'deal_amount' => $quote->total,
                            'note' => $data['date_deal'] ?? null
                        ]);
                        $project->pipeline_stage_id = 4;
                        $project->save();

                        foreach ($quote->quoteProducts as $item) {
                            ProjectActual::create([
                                'project_id' => $quote->project_id,
                                'product_id' => $item->product_id,
                                'quantity_quote' => $item->quantity,
                                'price' => $item->price,
                                'actual_quote' => $item->quantity * $item->price,
                            ]);
                        }

                        $project->pipelineStageLogs()->create([
                            'pipeline_stage_id' => 4,
                            'notes' => $data['notes'] ?? 'Final Quote',
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Quote deal project')
                            ->success()
                            ->send();
                    }),
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('created_at','DESC');
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
