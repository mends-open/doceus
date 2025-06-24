<?php

namespace App\Filament\Resources\Practitioners\Pages;

use App\Filament\Pages\EditRecord;
use App\Filament\Resources\Practitioners\PractitionerResource;

class EditPractitioner extends EditRecord
{
    protected static string $resource = PractitionerResource::class;

    protected function getFormActions(): array
    {
        return [

        ];
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
