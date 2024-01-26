<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportActualResource\Pages;
use App\Filament\Resources\ReportActualResource\RelationManagers;
use App\Models\ProjectActual;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportActualResource extends Resource
{
    protected static ?string $model = ProjectActual::class;

    #protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Report Actual';

    public static ?string $label = 'Report Actual';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->label('Hari/Tanggal'),
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable()
                    ->sortable()
                    ->label('Product'),
                Tables\Columns\TextColumn::make('product.items.name')
                    ->searchable()
                    ->sortable()
                    ->label('Product Item'),
                Tables\Columns\TextColumn::make('project.customer.customer_name')
                    ->searchable()
                    ->sortable()
                    ->label('Company / Clinic'),
                Tables\Columns\TextColumn::make('quantity_actual')
                    ->numeric()
                    ->sortable()
                    ->label('Pax'),
                Tables\Columns\TextColumn::make('price')
                    ->numeric()
                    ->sortable()
                    ->label('Harga'),
                Tables\Columns\TextColumn::make('actual_final')
                    /*->state(function (ProjectActual $record): float {
                        return $record->quantity_actual * $record->price;
                    })*/
                    ->numeric()
                    ->sortable()
                    ->label('Harga'),
                Tables\Columns\TextColumn::make('project.pipelineStageLogs_proposed.notes')
                    ->searchable()
                    ->sortable()
                    ->label('Notes'),
                Tables\Columns\TextColumn::make('project.employee.name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Sales'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\BulkActionGroup::make([
                //    Tables\Actions\DeleteBulkAction::make(),
                //]),
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
            'index' => Pages\ListReportActuals::route('/'),
            'create' => Pages\CreateReportActual::route('/create'),
            'edit' => Pages\EditReportActual::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
                        ->join('projects','projects.id','=','project_actuals.project_id')
                        ->where('projects.pipeline_stage_id', 6);
    }
}
