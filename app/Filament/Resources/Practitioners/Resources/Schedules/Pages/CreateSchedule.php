<?php

namespace App\Filament\Resources\Practitioners\Resources\Schedules\Pages;

use App\Filament\Resources\Practitioners\Resources\Schedules\ScheduleResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;

    protected ?int $locationId = null;

    protected ?int $organizationId = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var \App\Models\Practitioner $practitioner */
        $practitioner = $this->getParentRecord();
        $this->locationId = $data['location_id'] ?? null;
        $this->organizationId = Filament::getTenant()?->id;

        unset($data['location_id'], $data['practitioner_id']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $schedule = $this->record;
        if ($this->organizationId) {
            $schedule->organizations()->syncWithoutDetaching([$this->organizationId]);
        }

        $schedule->practitioners()->syncWithoutDetaching([$this->getParentRecord()->id]);

        if ($this->locationId) {
            $schedule->locations()->syncWithoutDetaching([$this->locationId]);
        }
    }
}
