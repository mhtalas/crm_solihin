<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportProposedResource\Pages;
use App\Filament\Resources\ReportProposedResource\RelationManagers;
use App\Models\ProductQuote;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportProposedResource extends Resource
{
    protected static ?string $model = ProductQuote::class;

    #protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Report Proposed';

    public static ?string $label = 'Report Proposed';

    protected static ?int $navigationSort = 3;

    public static function canViewAny(): bool
    {
        #return auth()->user()->name == 'Admin' ? true : false;
        #Post::find($id);
        $userlogin = User::find(auth()->user()->id);
        #$userauth = new User;
       # return $userauth->hasAnyPermission(['Report Visit List']);

       #return $userlogin->name == 'Admin';
       return $userlogin->hasAnyPermission(['Report Propossed List']) || $userlogin->is_admin;
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
                Tables\Columns\TextColumn::make('quote.created_at')
                    ->date()
                    ->sortable()
                    ->label('Hari/Tanggal'),
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable()
                    ->sortable()
                    ->label('Product'),
                Tables\Columns\TextColumn::make('product.items.name')
                    ->label('Product Item'),
                Tables\Columns\TextColumn::make('quote.project.customer.customer_name')
                    ->searchable()
                    ->sortable()
                    ->label('Company / Clinic'),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable()
                    ->label('Pax'),
                Tables\Columns\TextColumn::make('price')
                    ->numeric()
                    ->sortable()
                    ->label('Harga'),
                Tables\Columns\TextColumn::make('totalamount')
                    ->state(function (ProductQuote $record): float {
                        return $record->quantity * $record->price;
                    })
                    ->numeric()
                    //->sortable()
                    ->label('Total Harga'),
                Tables\Columns\TextColumn::make('quote.project.pipelineStageLogs_proposed.notes')
                    ->searchable()
                    ->sortable()
                    ->label('Notes'),
                /*Tables\Columns\IconColumn::make('quote.is_complete')
                    ->searchable()
                    ->sortable()
                    ->boolean()
                    ->label('Status Logo'),*/
                Tables\Columns\TextColumn::make('quote.is_complete')
                    ->label('Status')
                    ->formatStateUsing(function ($record) {
                        //$tagsList = view('customer.tagsList', ['tags' => $record->customer->tags])->render();
                        if($record->is_complete == true){
                            $text = 'Complete';
                        }else{
                            $text = 'Incomplete';
                        }
                        return '' . $text;
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('quote.project.employee.name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Sales'),
            ])
            ->defaultSort('quote.created_at', 'desc')
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
                                fn (Builder $query, $date): Builder => $query->whereDate('quotes.created_at', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_akhir'],
                                fn (Builder $query, $date): Builder => $query->whereDate('quotes.created_at', '<=', $date),
                            );
                    }),
                Tables\Filters\SelectFilter::make('name')
                    ->relationship('quote.project.employee', 'name')
                    ->label('Sales'),
                Tables\Filters\SelectFilter::make('customer_name')
                    ->relationship('quote.project.customer', 'customer_name')
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
            'index' => Pages\ListReportProposeds::route('/'),
            'create' => Pages\CreateReportProposed::route('/create'),
            'edit' => Pages\EditReportProposed::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
                        ->join('quotes','product_quote.quote_id','=','quotes.id')
                        ->join('projects','projects.id','=','quotes.project_id')
                        ->where('projects.pipeline_stage_id', 3);
    }

}
