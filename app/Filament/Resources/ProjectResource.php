<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Filament\Resources\QuoteResource\Pages\CreateQuote;
use App\Models\Customer;
use App\Models\PipelineStage;
use App\Models\Product;
use App\Models\Project;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Location\Facades\Location;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Information')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->options(function () {
                                $user = Auth::user();

                                // Periksa peran pengguna
                                if ($user && !$user->hasRole(['Admin', 'Super Admin'])) {
                                    // Logika jika bukan admin atau super admin
                                    // Ambil opsi pilihan berdasarkan customer_name
                                    return Customer::where('employee_id', $user->id)->pluck('customer_name', 'id');
                                } else {
                                    // Logika jika admin atau super admin
                                    // Ambil opsi pilihan berdasarkan employee_id
                                    return Customer::pluck('customer_name', 'id');
                                }
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('project_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('start_date')
                            ->required(),
                        Forms\Components\DatePicker::make('end_date'),
                        Forms\Components\Select::make('pipeline_stage_id')
                            ->relationship('pipelineStage', 'name', function ($query) {
                                // It is important to order by position to display the correct order
                                $query->orderBy('position', 'asc');
                            })
                            ->native(false)
                            ->columnSpanFull()
                            // We are setting the default value to the default Pipeline Stage
                            ->default(PipelineStage::where('is_default', true)->first()?->id),
                        Forms\Components\Select::make('Sales Colab')
                            ->translateLabel()
                            ->relationship('users', 'name')
                            ->columnSpanFull()
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText(fn() => trans('Add sales to colab project.')),

                    ])->columns(2),

                Forms\Components\Section::make('Actual Item')
                    ->visible(fn (string $operation): bool => $operation === 'edit')
                    ->schema([
                        Forms\Components\Repeater::make('actuals')
                            ->relationship('actuals')
                            ->addable(false)
                            ->deletable(false)
                            // ... (your other properties)
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->disabled()
                                    ->options(Product::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),
                                Forms\Components\TextInput::make('price')
                                    // ... (your other properties)
                                    ->readOnly()
                                    ->required(),
                                Forms\Components\TextInput::make('quantity_quote')
                                    // ... (your other properties)
                                    ->required(),
                                Forms\Components\TextInput::make('quantity_actual')
                                    ->live()
                                    ->numeric()
                                    ->afterStateUpdated(function (Forms\Set $set, Get $get, $state) {
                                        $total = $get('price') * $state;
                                        $set('actual_final', $total);
                                    })
                                    ->required(),
                                Forms\Components\TextInput::make('actual_quote')
                                    // ... (your other properties)
                                    ->readOnly()
                                    ->required(),
                                Forms\Components\TextInput::make('actual_final')
                                    ->readOnly()
                                    ->default(100)
                                    ->required(),
                            ])
                            ->columns(2)
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
                        $query->whereHas('users', function ($userQuery) use ($userId) {
                            $userQuery->where('id', $userId);
                        })
                            ->orWhere('employee_id', $user->id);
                    });
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('customer.customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.customer_name')
                    ->label('Customer')
                    ->formatStateUsing(function ($record) {
                        $tagsList = view('customer.tagsList', ['tags' => $record->customer->tags])->render();

                        return $record->customer->customer_name . ' ' . $tagsList;
                    })
                    ->html()
                    ->searchable(['customer_name']),
                Tables\Columns\TextColumn::make('project_name')
                    ->label('Project Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Project Owner')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Sales Colab')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pipelineStage.name')
                    ->label('Status'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Move to Stage')
                        ->hidden(fn($record) => $record->trashed())
                        ->icon('heroicon-m-pencil-square')
                        ->form([
                            Forms\Components\Select::make('pipeline_stage_id')
                                ->label('Status')
//                                ->disabled()
                                ->live()
                                ->native(false)
                                ->options(PipelineStage::pluck('name', 'id')->toArray())
                                ->default(function (Project $record) {
                                    $currentPosition = $record->pipelineStage->position;
                                    return PipelineStage::where('position', '>', $currentPosition)->first()?->id;
                                }),
                            Forms\Components\Textarea::make('notes')
                                ->label('Notes'),
                            Forms\Components\FileUpload::make('file')
                                ->maxSize(10240)
                                ->dehydrated()
                                ->live()
                                ->required(function (Get $get) {
                                    // Make the file upload required only when pipeline_stage_id is 3
                                    return $get('pipeline_stage_id') === 3;
                                })
                                ->downloadable()
                                ->previewable()
                                ->openable()
                        ])
                        ->action(function (Project $project, array $data): void {
                            $project->pipeline_stage_id = $data['pipeline_stage_id'];
                            $project->save();

                            $project->pipelineStageLogs()->create([
                                'pipeline_stage_id' => $data['pipeline_stage_id'],
                                'notes' => $data['notes'],
                                'user_id' => auth()->id(),
                                'file' => $data['file'] ?? null
                            ]);

                            Notification::make()
                                ->title('Project Pipeline Updated')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('Add Task')
                        ->icon('heroicon-s-clipboard-document')
                        ->form([
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

                        ])
                        ->action(function (Project $project, array $data) {
                            $project->tasks()->create($data);

                            Notification::make()
                                ->title('Task created successfully')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('Create Quotation')
                        ->icon('heroicon-m-book-open')
                        ->url(function ($record) {
                            return CreateQuote::getUrl(['project_id' => $record->id]);
                        })->visible(function ($record) {
                            if ($record->deal_amount !== '0') {
                                return false;
                            } else {
                                return true;
                            }
                        }),
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
            ])->defaultSort('created_at', 'desc');
    }

    public static function infoList(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Project Information')
                    ->schema([
                        TextEntry::make('project_name'),
                        TextEntry::make('employee.name')
                            ->label('Project Owner'),
                        TextEntry::make('users.name')
                            ->label('Sales Colab'),
                    ])
                    ->columns(3),
                Section::make('Project Deal')
                    ->schema([
                        TextEntry::make('end_date')
                            ->date()
                            ->label('Date Deal'),
                        TextEntry::make('deal_amount')
                            ->label('Deal Amount'),
                        TextEntry::make('note')
                            ->label('Note'),
                    ])
                    ->columns(3),
                Section::make('Contact Information')
                    ->schema([
                        TextEntry::make('customer.customer_name')
                            ->label('Customer Name'),
                        TextEntry::make('customer.pic_name')
                            ->label('PIC Name'),
                        TextEntry::make('customer.customer_email')
                            ->label('Customer Email'),
                        TextEntry::make('customer.phone_number')
                            ->label('Phone Number'),
                        TextEntry::make('customer.province.name')
                            ->label('Province'),
                        TextEntry::make('customer.city.name')
                            ->label('City'),
                        TextEntry::make('customer.address')
                            ->label('Address')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),
//                Section::make('Additional Details')
//                    ->schema([
//                        TextEntry::make('description'),
//                    ]),
                Section::make('Lead and Stage Information')
                    ->schema([
                        TextEntry::make('leadSource.name'),
                        TextEntry::make('pipelineStage.name'),
                    ])
                    ->columns(),

                Section::make('Pipeline Stage History and Notes')
                    ->schema([
                        ViewEntry::make('pipelineStageLogs')
                            ->label('')
                            ->view('infolists.components.pipeline-stage-history-list'),
                    ])
                    ->collapsible(),
                Tabs::make('Tasks')
                    ->tabs([
                        Tabs\Tab::make('Completed')
                            ->badge(fn($record) => $record->completedTasks->count())
                            ->schema([
                                RepeatableEntry::make('completedTasks')
                                    ->hiddenLabel()
                                    ->schema([
                                        TextEntry::make('task_name')
                                            ->label('Task Name')
                                            ->columnSpanFull(),
                                        TextEntry::make('description')
                                            ->html()
                                            ->columnSpanFull(),
                                        TextEntry::make('result')
                                            ->html()
                                            ->columnSpanFull(),
                                        TextEntry::make('employee.name')
                                            ->hidden(fn($state) => is_null($state)),
                                        TextEntry::make('due_date')
                                            ->label('Date')
                                            ->hidden(fn($state) => is_null($state))
                                            ->date(),
                                        TextEntry::make('file')
                                            ->label('Document')
                                            // This will rename the column to "Download Document" (otherwise, it's just the file name)
                                            ->formatStateUsing(fn() => "Download Document")
                                            ->url(fn($record) => Storage::url($record->file), true)
                                            // This will make the link look like a "badge" (blue)
                                            ->badge()
                                            ->color(Color::Blue),
                                    ])
                                    ->columns()
                            ]),
                        Tabs\Tab::make('Incomplete')
                            ->badge(fn($record) => $record->incompleteTasks->count())
                            ->schema([
                                RepeatableEntry::make('incompleteTasks')
                                    ->hiddenLabel()
                                    ->schema([
                                        TextEntry::make('task_name')
                                            ->label('Task Name')
                                            ->columnSpanFull(),
                                        TextEntry::make('description')
                                            ->html()
                                            ->columnSpanFull(),
                                        TextEntry::make('result')
                                            ->html()
                                            ->columnSpanFull(),
                                        TextEntry::make('employee.name')
                                            ->hidden(fn($state) => is_null($state)),
                                        TextEntry::make('due_date')
                                            ->label('Date')
                                            ->hidden(fn($state) => is_null($state))
                                            ->date(),
                                        TextEntry::make('is_completed')
                                            ->formatStateUsing(function ($state) {
                                                return $state ? 'Yes' : 'No';
                                            })
                                            ->suffixAction(
                                                Action::make('complete')
                                                    ->button()
                                                    ->requiresConfirmation()
                                                    ->modalHeading('Mark task as completed?')
                                                    ->modalDescription('Are you sure you want to mark this task as completed?')
                                                    ->action(function (Task $record) {
                                                        $record->is_completed = true;
                                                        $record->save();

                                                        Notification::make()
                                                            ->title('Task marked as completed')
                                                            ->success()
                                                            ->send();
                                                    })
                                            ),
                                        TextEntry::make('file')
                                            ->label('Document')
                                            // This will rename the column to "Download Document" (otherwise, it's just the file name)
                                            ->formatStateUsing(fn() => "Download Document")
                                            ->url(fn($record) => Storage::url($record->file), true)
                                            // This will make the link look like a "badge" (blue)
                                            ->badge()
                                            ->color(Color::Blue),
                                    ])
                                    ->columns(3)
                            ])
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\QuotesRelationManager::class,
            RelationManagers\ActualsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
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
