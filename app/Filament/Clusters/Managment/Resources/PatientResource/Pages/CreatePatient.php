<?php

namespace App\Filament\Clusters\Managment\Resources\PatientResource\Pages;

use App\Filament\Clusters\Managment\Resources\PatientResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;
}

