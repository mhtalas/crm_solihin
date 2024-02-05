<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportActualResource\Pages;
use App\Filament\Resources\ReportActualResource\RelationManagers;
use App\Models\ProjectActual;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
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

    protected static ?int $navigationSort = 4;


    public static function canViewAny(): bool
    {
        #return auth()->user()->name == 'Admin' ? true : false;
        #Post::find($id);
        $userlogin = User::find(auth()->user()->id);
        #$userauth = new User;
       # return $userauth->hasAnyPermission(['Report Visit List']);

       #return $userlogin->name == 'Admin';
       return $userlogin->hasAnyPermission(['Report Actual List']) || $userlogin->is_admin;
    }

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
                Tables\Columns\TextColumn::make('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(['project_actuals.created_at'])
                    ->label('Hari/Tanggal'),
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable()
                    ->sortable()
                    ->label('Product'),
                Tables\Columns\TextColumn::make('product.items.name')
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
                    ->label('Total Harga'),
                Tables\Columns\TextColumn::make('project.pipelineStageLogs_proposed.notes')
                    ->searchable()
                    ->sortable()
                    ->label('Notes'),
                Tables\Columns\TextColumn::make('project.employee.name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Sales'),
            ])
            ->defaultSort('project_actuals.created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('start_date')
                    ->form([
                        DatePicker::make('tanggal_awal')
                            ->default(now()->subMonths(1)),
                        DatePicker::make('tanggal_akhir')
                            ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_awal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('project_actuals.created_at', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_akhir'],
                                fn (Builder $query, $date): Builder => $query->whereDate('project_actuals.created_at', '<=', $date),
                            );
                    }),
                Tables\Filters\SelectFilter::make('name')
                    ->relationship('project.employee', 'name')
                    ->label('Sales'),
                Tables\Filters\SelectFilter::make('customer_name')
                    ->relationship('project.customer', 'customer_name')
                    ->label('Company / Clinic'),
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
