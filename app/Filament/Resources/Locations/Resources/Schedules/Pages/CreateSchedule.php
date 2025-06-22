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
        $data['location_id'] = $this->location->id;
        $data['schedulable_type'] = $this->location::class;
        $data['schedulable_id'] = $this->location->id;

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->organizations()->attach($this->location->organization_id);
    }
}
