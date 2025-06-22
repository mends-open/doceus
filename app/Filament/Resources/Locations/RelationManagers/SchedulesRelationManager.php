<?php

namespace App\Filament\Resources\Locations\RelationManagers;

use App\Filament\Resources\Schedules\Schemas\ScheduleForm;
use App\Filament\Resources\Schedules\Tables\SchedulesTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    public function form(Schema $schema): Schema
    {
        return ScheduleForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return SchedulesTable::configure($table);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['location_id'] = $this->ownerRecord->id;
        $data['organization_id'] = $this->ownerRecord->organization_id;

        return $data;
    }
}
