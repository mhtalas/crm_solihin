<?php

namespace App\Filament\Resources\ReportVisitResource\Pages;

use App\Filament\Resources\ReportVisitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportVisits extends ListRecords
{
    protected static string $resource = ReportVisitResource::class;

    protected function getHeaderActions(): array
    {
        $qr_string = urldecode(request()->getQueryString());
        return [
            Actions\Action::make('export')
                ->url(url('/export-report-visit?'.$qr_string)),
        ];
    }
}
