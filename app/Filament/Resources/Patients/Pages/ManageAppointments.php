<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use App\Filament\Resources\Patients\Resources\Appointments\AppointmentResource;
use Filament\Resources\Pages\ManageRelatedRecords;

class ManageAppointments extends ManageRelatedRecords
{
    protected static string $resource = PatientResource::class;

    protected static string $relationship = 'appointments';

    protected static ?string $relatedResource = AppointmentResource::class;
}
