<?php

namespace App\Filament\Clusters\Managment\Resources\PersonResource\Pages;

use App\Filament\Clusters\Managment\Resources\PersonResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePerson extends CreateRecord
{
    protected static string $resource = PersonResource::class;
}
