<?php

namespace App\Filament\Resources\Locations\RelationManagers;

use App\Filament\Resources\Locations\Resources\Schedules\ScheduleResource;
use Filament\Resources\RelationManagers\RelationManager;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    protected static ?string $relatedResource = ScheduleResource::class;
}
