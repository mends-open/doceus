<?php

namespace App\Filament\Clusters\Managment\Resources\PatientResource\Pages;

use App\Filament\Clusters\Managment\Resources\PatientResource;
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

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->record->person->update($data['person'] ?? []);

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
