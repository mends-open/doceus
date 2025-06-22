<?php

namespace App\Filament\Resources\Practitioners\RelationManagers;

use App\Filament\Resources\Practitioners\Resources\Schedules\ScheduleResource;
use Filament\Resources\RelationManagers\RelationManager;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    protected static ?string $relatedResource = ScheduleResource::class;
}
