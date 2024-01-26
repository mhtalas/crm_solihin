<?php

namespace App\Filament\Resources\ReportTaskResource\Pages;

use App\Filament\Resources\ReportTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportTasks extends ListRecords
{
    protected static string $resource = ReportTaskResource::class;

    protected function getHeaderActions(): array
    {
        //return [
            //Actions\CreateAction::make(),
        //];

        $qr_string = urldecode(request()->getQueryString());
        return [
            Actions\Action::make('export')
                ->url(url('/export-report-task?'.$qr_string)),
        ];

    }
}
