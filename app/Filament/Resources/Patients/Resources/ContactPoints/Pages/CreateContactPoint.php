<?php

namespace App\Filament\Resources\Patients\Resources\ContactPoints\Pages;

use App\Filament\Resources\Patients\Resources\ContactPoints\ContactPointResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactPoint extends CreateRecord
{
    protected static string $resource = ContactPointResource::class;
}
