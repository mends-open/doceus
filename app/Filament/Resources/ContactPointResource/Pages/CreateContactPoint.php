<?php

namespace App\Filament\Resources\ContactPointResource\Pages;

use App\Filament\Resources\ContactPointResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContactPoint extends CreateRecord
{
    protected static string $resource = ContactPointResource::class;
}
