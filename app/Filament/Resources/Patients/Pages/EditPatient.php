<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected array $tagIds = [];

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['tag_ids'] = $this->record
            ->tags()
            ->pluck('id')
            ->map(fn (int $id) => (string) $id)
            ->all();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->tagIds = $data['tag_ids'] ?? [];
        unset($data['tag_ids']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->tags()->sync($this->tagIds);
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
