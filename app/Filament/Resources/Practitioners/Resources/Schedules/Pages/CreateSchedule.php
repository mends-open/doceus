<?php

namespace App\Filament\Resources\Practitioners\Resources\Schedules\Pages;

use App\Filament\Resources\Practitioners\Resources\Schedules\ScheduleResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var \App\Models\Practitioner $practitioner */
        $practitioner = $this->getParentRecord();
        $data['practitioner_id'] = $practitioner->id;
        $data['organization_id'] = Filament::getTenant()?->id;

        return $data;
    }
}
