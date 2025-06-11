<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected array $tagIds = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->tagIds = $data['tag_ids'] ?? [];
        unset($data['tag_ids']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->tags()->sync($this->tagIds);
    }
}
