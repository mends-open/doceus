<?php

namespace App\Filament\Resources\Locations\Resources\Schedules\Pages;

use App\Filament\Resources\Locations\Resources\Schedules\ScheduleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;

    protected ?\App\Models\Location $location = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->location = $this->getParentRecord();

        unset($data['location_id'], $data['practitioner_id']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->locations()->attach($this->location->id);
        $this->record->organizations()->attach($this->location->organization_id);
    }
}
