<?php

namespace App\Filament\Resources\Patients\Resources\Appointments\Pages;

use App\Filament\Resources\Patients\Resources\Appointments\AppointmentResource;
use App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\EncounterResource;
use Filament\Resources\Pages\ManageRelatedRecords;

class ManageEncounters extends ManageRelatedRecords
{
    protected static string $resource = AppointmentResource::class;

    protected static string $relationship = 'encounters';

    protected static ?string $relatedResource = EncounterResource::class;
}
