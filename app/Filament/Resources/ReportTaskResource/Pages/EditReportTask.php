<?php

namespace App\Filament\Resources\ReportTaskResource\Pages;

use App\Filament\Resources\ReportTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportTask extends EditRecord
{
    protected static string $resource = ReportTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
