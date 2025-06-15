<?php

namespace App\Filament\Resources\Patients\Resources\Appointments\Pages;

use App\Filament\Resources\Patients\Resources\Appointments\AppointmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;
}
