<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use App\Models\Person;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $personData = $data['person'] ?? [];
        unset($data['person']);

        $person = Person::create($personData);
        $data['person_id'] = $person->id;

        return static::getModel()::create($data);
    }
}
