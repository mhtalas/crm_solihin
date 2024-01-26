<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'project_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('task_name')
                    ->label('Nama Task')
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->label('Rincian / Rencana')
                    ->required(),
                Forms\Components\RichEditor::make('result')
                    ->label('HASIL / LANGKAH SELANJUTNYA')
                    ->required(),
                Forms\Components\DatePicker::make('due_date')
                    ->native(false),
                Forms\Components\FileUpload::make('file')
                    ->downloadable()
                    ->previewable()
                    ->openable(),

                Forms\Components\Hidden::make('user_id')
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
                        $query->whereHas('project', function ($userQuery) use ($userId) {
                            $userQuery->where('id', $userId);
                        });
                    });
                }
            })
            ->columns([
                Tables\Columns\IconColumn::make('is_completed')
                    ->boolean(),
                Tables\Columns\TextColumn::make('project.project_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('task_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
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
                Tables\Actions\Action::make('Complete')
                    ->hidden(fn (Task $record) => $record->is_completed)
                    ->icon('heroicon-m-check-badge')
                    ->modalHeading('Mark task as completed?')
                    ->modalDescription('Are you sure you want to mark this task as completed?')
                    ->action(function (Task $record) {
                        $record->is_completed = true;
                        $record->save();

                        Notification::make()
                            ->title('Task marked as completed')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'view' => Pages\ViewTask::route('/{record}'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
