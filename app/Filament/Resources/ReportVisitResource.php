<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportVisitResource\Pages;
use App\Filament\Resources\ReportVisitResource\RelationManagers;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportVisitResource extends Resource
{
    #protected static ?string $model = Task::class;
    protected static ?string $model = Project::class;

    #protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Report Visit';

    public static ?string $label = 'Report Visit';

    protected static ?int $navigationSort = 1;

    protected static bool $shouldRegisterNavigation = true;


    public static function canViewAny(): bool
    {
        #return auth()->user()->name == 'Admin' ? true : false;
        #Post::find($id);
        $userlogin = User::find(auth()->user()->id);
        #$userauth = new User;
       # return $userauth->hasAnyPermission(['Report Visit List']);

       #return $userlogin->name == 'Admin';
       return $userlogin->hasAnyPermission(['Report Visit List']) || $userlogin->is_admin;
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
            /*->modifyQueryUsing(fn (Builder $query) => 
                $query->where('is_completed', 
                false))*/
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable()
                    ->label('Hari/Tanggal'),
                Tables\Columns\TextColumn::make('customer.customer_name')
                    ->searchable()
                    ->sortable()
                    ->label('Company/Clinic Name'),
                Tables\Columns\TextColumn::make('customer.pic_name')
                    ->searchable()
                    ->sortable()
                    ->label('PIC Clien'),
                Tables\Columns\TextColumn::make('pipelineStageLogs_visit.notes')
                    ->html()
                    ->label('Result Visit'),
                Tables\Columns\TextColumn::make('employee.name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Sales'),
                Tables\Columns\TextColumn::make('customer.tags')
                    ->label('Tag')
                    ->formatStateUsing(function ($record) {
                        $tagsList = view('customer.tagsList', ['tags' => $record->customer->tags])->render();

                        return ' ' . $tagsList;
                    })
                    ->html(),
            ])
            ->defaultSort('start_date', 'desc')
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
                                        fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                                    )
                                    ->when(
                                        $data['tanggal_akhir'],
                                        fn (Builder $query, $date): Builder => $query->whereDate('start_date', '<=', $date),
                                    );
                            }),
                Tables\Filters\SelectFilter::make('name')
                            ->relationship('employee', 'name')
                            ->label('Sales'),
                Tables\Filters\SelectFilter::make('customer_name')
                            ->relationship('customer', 'customer_name')
                            ->label('Company / Clinic'),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                
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
            'index' => Pages\ListReportVisits::route('/'),
            'create' => Pages\CreateReportVisit::route('/create'),
            'edit' => Pages\EditReportVisit::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        #jika tasks
        #return parent::getEloquentQuery()
        #                ->join('projects','projects.id','=','tasks.project_id')        
        #                ->where('projects.pipeline_stage_id', 2);

        return parent::getEloquentQuery()
                        ->where('pipeline_stage_id', 2);
    }

}
