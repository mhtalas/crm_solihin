<?php

namespace App\Filament\Resources\ReportActualResource\Pages;

use App\Filament\Resources\ReportActualResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportActual extends EditRecord
{
    protected static string $resource = ReportActualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
