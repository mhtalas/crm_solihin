<?php

namespace App\Filament\Resources\ReportProposedResource\Pages;

use App\Filament\Resources\ReportProposedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportProposed extends EditRecord
{
    protected static string $resource = ReportProposedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
