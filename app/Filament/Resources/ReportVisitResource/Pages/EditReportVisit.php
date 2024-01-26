<?php

namespace App\Filament\Resources\ReportVisitResource\Pages;

use App\Filament\Resources\ReportVisitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportVisit extends EditRecord
{
    protected static string $resource = ReportVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
