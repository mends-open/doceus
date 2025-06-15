<?php

namespace App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\Pages;

use App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\EncounterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEncounter extends CreateRecord
{
    protected static string $resource = EncounterResource::class;
}
