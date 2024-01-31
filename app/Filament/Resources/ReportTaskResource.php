<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportTaskResource\Pages;
use App\Filament\Resources\ReportTaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ReportTaskResource extends Resource
{
    protected static ?string $model = Task::class;

    #protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Report Task';

    protected static ?string $navigationGroup = 'Reports';

    public static ?string $label = 'Report Task';



    

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
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable()
                    ->label('Hari/Tanggal'),
                Tables\Columns\TextColumn::make('project.customer.customer_name')
                    ->searchable()
                    ->sortable()
                    ->label('Company/Clinic Name'),
                Tables\Columns\TextColumn::make('project.customer.pic_name')
                    ->searchable()
                    ->sortable()
                    ->label('PIC Clien'),
                Tables\Columns\TextColumn::make('description')
                    ->html()
                    ->label('Deskripsi'),
                Tables\Columns\TextColumn::make('employee.name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Sales'),
                /*Tables\Columns\IconColumn::make('is_completed')
                    ->searchable()
                    ->sortable()
                    ->boolean()
                    ->label('Status'),*/
                Tables\Columns\TextColumn::make('is_completed')
                    ->label('Status')
                    ->formatStateUsing(function ($record) {
                        //$tagsList = view('customer.tagsList', ['tags' => $record->customer->tags])->render();
                        if($record->is_completed == true){
                            $text = 'Complete';
                        }else{
                            $text = 'Incomplete';
                        }
                        return '' . $text;
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('project.customer.tags.name')
                    ->searchable()
                    ->sortable()
                    ->label('Tag'),
            ])
            ->defaultSort('due_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('due_date')
                            ->form([
                                DatePicker::make('due_date_awal')
                                ->default(now()->subMonths(1)),
                                DatePicker::make('due_date_akhir')
                                ->default(now()),
                            ])
                            ->query(function (Builder $query, array $data): Builder {
                                return $query
                                    ->when(
                                        $data['due_date_awal'],
                                        fn (Builder $query, $date): Builder => $query->whereDate('due_date', '>=', $date),
                                    )
                                    ->when(
                                        $data['due_date_akhir'],
                                        fn (Builder $query, $date): Builder => $query->whereDate('due_date', '<=', $date),
                                    );
                            }),        
                Tables\Filters\SelectFilter::make('name')
                    ->relationship('employee', 'name')
                    ->label('Sales'),
                Tables\Filters\SelectFilter::make('customer_name')
                    ->relationship('project.customer', 'customer_name')
                    ->label('Company / Clinic'),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ;
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
            'index' => Pages\ListReportTasks::route('/'),
            'create' => Pages\CreateReportTask::route('/create'),
            'edit' => Pages\EditReportTask::route('/{record}/edit'),
        ];
    }
}
