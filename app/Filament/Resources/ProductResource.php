<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Toggle::make('is_package')
                        ->live()
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\Select::make('Product Item')
                        ->label('Item Package')
                        ->visible(function (Forms\Get $get) {
                            if ($get('is_package') === true) {
                                return true;
                            } else {
                                return false;
                            }
                        })
                        ->translateLabel()
                        ->relationship('items', 'name')
                        ->columnSpanFull()
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->required()
                        ->helperText(fn() => trans('Add item to package product.')),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('description')
                        ->columnSpanFull(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_package')
                    ->boolean(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('items.name')
                    ->label('Product Item')
                    ->listWithLineBreaks()
                    ->limitList(5)
                    ->bulleted()
                    ->expandableLimitedList()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
