<?php

namespace App\Filament\Resources\Schedules\Pages;

use App\Filament\Resources\Schedules\ScheduleResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $practitionerId = Arr::pull($data, 'practitioner_id');

        $schedule = parent::handleRecordCreation($data);

        if ($practitionerId) {
            $schedule->practitioners()->attach($practitionerId);
        }

        $schedule->organizations()->syncWithoutDetaching([$schedule->location->organization_id]);

        return $schedule;
    }
}
