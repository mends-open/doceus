<?php

namespace App\Filament\Resources\Locations\Resources\Schedules\Pages;

use App\Filament\Resources\Locations\Resources\Schedules\ScheduleResource;
use App\Models\Organization;
use Filament\Resources\Pages\CreateRecord;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;

    protected ?\App\Models\Location $location = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->location = $this->getParentRecord();
        $data['schedulable_type'] = Organization::class;
        $data['schedulable_id'] = $this->location->organization_id;

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->locations()->attach($this->location);
        $this->record->organizations()->attach($this->location->organization_id);
    }
}
