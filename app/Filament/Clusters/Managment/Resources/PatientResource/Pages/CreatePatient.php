<?php

namespace App\Filament\Clusters\Managment\Resources\PatientResource\Pages;

use App\Filament\Clusters\Managment\Resources\PatientResource;
use App\Feature\Identity\Enums\ContactPointSystem;
use App\Feature\Identity\Enums\ContactableType;
use App\Models\Person;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $personData = $data['person'] ?? [];

        $emails = collect($personData['emails'] ?? [])
            ->pluck('value')
            ->filter()
            ->toArray();
        $phones = collect($personData['phones'] ?? [])
            ->pluck('value')
            ->filter()
            ->toArray();

        unset($personData['emails'], $personData['phones']);

        $person = Person::create($personData);

        foreach ($emails as $email) {
            $person->contactPoints()->create([
                'contactable_type' => ContactableType::Person,
                'system' => ContactPointSystem::Email,
                'value' => $email,
            ]);
        }

        foreach ($phones as $phone) {
            $person->contactPoints()->create([
                'contactable_type' => ContactableType::Person,
                'system' => ContactPointSystem::Phone,
                'value' => $phone,
            ]);
        }

        $data['person_id'] = $person->id;

        unset($data['person']);

        return $data;
    }
}
