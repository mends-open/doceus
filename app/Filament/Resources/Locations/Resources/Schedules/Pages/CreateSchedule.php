<?php

namespace App\Filament\Resources\Locations\Resources\Schedules\Pages;

use App\Filament\Resources\Locations\Resources\Schedules\ScheduleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var \App\Models\Location $location */
        $location = $this->getParentRecord();
        $data['location_id'] = $location->id;
        $data['organization_id'] = $location->organization_id;

        return $data;
    }
}
