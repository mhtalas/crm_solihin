<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    public function create(bool $another = false): void
    {
        parent::create($another);  // Call the parent's create method

        // Redirect to the index page for the resource
        $this->redirect(static::getResource()::getUrl('index'));
    }

}

