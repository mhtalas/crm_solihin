<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\View\View;
use App\Models\Task;

class ReportTask extends Page
{
    protected static string $view = 'filament.pages.report-task';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Report Task Page';

    protected static ?string $slud = 'report/reportTaskPage';

    protected ?string $heading = 'Report Task';

    protected static bool $shouldRegisterNavigation = false; #hidden menu



    public ?array $data = [];

    public ?Task $record = null;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->alignleft(),
                TextColumn::make('body')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->alignleft(),
               
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('title')
                    ->options(Product::select('title')
                        ->distinct()
                        ->get()
                        ->pluck('title', 'title')
                    )
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportTasks::route('/'),
        ];
    }

}
