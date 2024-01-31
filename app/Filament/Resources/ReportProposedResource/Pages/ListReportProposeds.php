<?php

namespace App\Filament\Resources\ReportProposedResource\Pages;

use App\Filament\Resources\ReportProposedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportProposeds extends ListRecords
{
    protected static string $resource = ReportProposedResource::class;

    protected function getHeaderActions(): array
    {
        $qr_string = urldecode(request()->getQueryString());
        return [
            Actions\Action::make('download')
                ->url(url('/export-report-proposed?'.$qr_string)),
        ];
    }
}
