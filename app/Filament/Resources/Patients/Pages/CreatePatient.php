<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use App\Models\Person;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $personData = Arr::pull($data, 'person', []);
        $person = Person::create($personData);
        $data['person_id'] = $person->id;

        return parent::handleRecordCreation($data);
    }
}
