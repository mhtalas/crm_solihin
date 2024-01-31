<?php

namespace App\Filament\Resources\ReportActualResource\Pages;

use App\Filament\Resources\ReportActualResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportActuals extends ListRecords
{
    protected static string $resource = ReportActualResource::class;

    protected function getHeaderActions(): array
    {
        $qr_string = urldecode(request()->getQueryString());
        return [
            Actions\Action::make('download')
                ->url(url('/export-report-actual?'.$qr_string)),
        ];
    }
}
