<?php

namespace App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\Pages;

use App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\EncounterResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEncounter extends ViewRecord
{
    protected static string $resource = EncounterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
