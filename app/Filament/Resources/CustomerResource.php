<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\City;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make("Client Information")
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Customer Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('customer_email')
                            ->required()
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('pic_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\Select::make('lead_source_id')
                            ->relationship('leadSource', 'name')
                            ->native(false),
                        Forms\Components\Select::make('tags')
                            ->relationship('tags', 'name')
                            ->searchable()
                            ->preload()
                            ->multiple(),
                    ])->columns(2),
                Forms\Components\Section::make('Client Address')
                    ->schema([
                        Forms\Components\Select::make('province_id')
                            ->label('Province')
                            ->relationship(name: 'province', titleAttribute: 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Forms\Set $set) {
                                $set('city_id', null);
                            })
                            ->required(),
                        Forms\Components\Select::make('city_id')
                            ->label('City')
                            ->options(fn(Forms\Get $get): Collection => City::query()
                                ->where('province_id', $get('province_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                        Forms\Components\MarkdownEditor::make('address')
                            ->columnSpanFull(),
                    ])->columns(2),
                Forms\Components\Section::make('Documents')
                    // This will make the section visible only on the edit page
                    ->schema([
                        Forms\Components\Repeater::make('documents')
                            ->relationship('documents')
                            ->hiddenLabel()
                            ->reorderable(false)
                            ->addActionLabel('Add Document')
                            ->schema([
                                Forms\Components\FileUpload::make('file_path')
                                    ->downloadable()
                                    ->previewable()
                                    ->openable()
                                    ->required(),
                                Forms\Components\Textarea::make('comments'),
                            ])
                            ->columns()
                    ]),
                Forms\Components\Hidden::make('employee_id')
                    ->default(\Auth::user()->id),
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
                        $query->whereHas('employee', function ($userQuery) use ($userId) {
                            $userQuery->where('id', $userId);
                        })
                            ->orWhere('employee_id', $user->id);
                    });
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer Name')
                    ->formatStateUsing(function ($record) {
                        $tagsList = view('customer.tagsList', ['tags' => $record->tags])->render();

                        return $record->customer_name . ' ' . $tagsList;
                    })
                    ->html()
                    ->searchable(['customer_name']),
                Tables\Columns\TextColumn::make('customer_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pic_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('leadSource.name')
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
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ], position: Tables\Enums\ActionsPosition::BeforeCells)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
