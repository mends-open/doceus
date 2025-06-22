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

        $data['practitioner_id'] = $practitioner->id;
        $data['organization_id'] = $this->organizationId;

        return $data;
    }

    protected function afterCreate(): void
    {
        //
    }
}
