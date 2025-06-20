<?php

namespace App\Filament\Resources\Schedules\Pages;

use App\Filament\Resources\Schedules\ScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditSchedule extends EditRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $practitionerId = Arr::pull($data, 'practitioner_id');

        $record = parent::handleRecordUpdate($record, $data);

        if ($practitionerId) {
            $record->practitioners()->sync([$practitionerId]);
        }

        $record->organizations()->syncWithoutDetaching([$record->location->organization_id]);

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
