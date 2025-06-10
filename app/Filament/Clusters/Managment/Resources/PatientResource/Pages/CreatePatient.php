<?php

namespace App\Filament\Clusters\Managment\Resources\PatientResource\Pages;

use App\Filament\Clusters\Managment\Resources\PatientResource;
use App\Models\Person;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $personData = $data['person'] ?? [];

        $person = Person::create($personData);

        $data['person_id'] = $person->id;

        unset($data['person']);

        return $data;
    }
}
