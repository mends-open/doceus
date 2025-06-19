<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Illuminate\Support\Arr;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['person'] = Arr::only(
            $this->record->person->toArray(),
            [
                'first_name',
                'last_name',
                'pesel',
                'identity_number',
                'identity_type',
                'gender',
                'birth_date',
            ]
        );

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
