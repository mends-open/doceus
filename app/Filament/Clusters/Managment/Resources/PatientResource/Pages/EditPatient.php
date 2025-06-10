<?php

namespace App\Filament\Clusters\Managment\Resources\PatientResource\Pages;

use App\Filament\Clusters\Managment\Resources\PatientResource;
use App\Feature\Identity\Enums\ContactableType;
use App\Feature\Identity\Enums\ContactPointSystem;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['person'] = $this->record->person->only([
            'first_name',
            'last_name',
            'pesel',
            'id_number',
            'gender',
            'birth_date',
        ]);

        $data['person']['emails'] = $this->record->person->emails
            ->map(
                fn ($point) => [
                    'value' => $point->value,
                    'contactable_type' => ContactableType::Person,
                    'system' => ContactPointSystem::Email,
                ],
            )
            ->toArray();

        $data['person']['phones'] = $this->record->person->phones
            ->map(
                fn ($point) => [
                    'value' => $point->value,
                    'contactable_type' => ContactableType::Person,
                    'system' => ContactPointSystem::Phone,
                ],
            )
            ->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
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

        $this->record->person->update($personData);

        $this->record->person->emails()->delete();
        foreach ($emails as $email) {
            $this->record->person->contactPoints()->create([
                'contactable_type' => ContactableType::Person,
                'system' => ContactPointSystem::Email,
                'value' => $email,
            ]);
        }

        $this->record->person->phones()->delete();
        foreach ($phones as $phone) {
            $this->record->person->contactPoints()->create([
                'contactable_type' => ContactableType::Person,
                'system' => ContactPointSystem::Phone,
                'value' => $phone,
            ]);
        }

        unset($data['person']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
