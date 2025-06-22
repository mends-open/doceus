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

        $data['schedulable_type'] = $practitioner::class;
        $data['schedulable_id'] = $practitioner->id;

        return $data;
    }

    protected function afterCreate(): void
    {
        $schedule = $this->record;
        if ($this->organizationId) {
            $schedule->organizations()->attach($this->organizationId);
        }
        $schedule->practitioners()->attach($schedule->schedulable_id);
    }
}
