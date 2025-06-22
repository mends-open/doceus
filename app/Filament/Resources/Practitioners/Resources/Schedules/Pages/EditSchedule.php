<?php

namespace App\Filament\Resources\Practitioners\Resources\Schedules\Pages;

use App\Filament\Resources\Practitioners\Resources\Schedules\ScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;

class EditSchedule extends EditRecord
{
    protected static string $resource = ScheduleResource::class;

    protected ?int $locationId = null;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->locationId = $data['location_id'] ?? null;

        unset($data['location_id'], $data['practitioner_id']);

        return $data;
    }

    protected function afterSave(): void
    {
        $schedule = $this->record;

        if ($tenantId = Filament::getTenant()?->id) {
            $schedule->organizations()->sync([$tenantId]);
        }

        $schedule->practitioners()->sync([$this->getParentRecord()->id]);

        if ($this->locationId) {
            $schedule->locations()->sync([$this->locationId]);
        } else {
            $schedule->locations()->sync([]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
