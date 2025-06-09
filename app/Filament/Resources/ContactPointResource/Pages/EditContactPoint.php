<?php

namespace App\Filament\Resources\ContactPointResource\Pages;

use App\Filament\Resources\ContactPointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactPoint extends EditRecord
{
    protected static string $resource = ContactPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
