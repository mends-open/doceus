<?php

namespace App\Filament\Resources\Practitioners\Resources\Schedules;

use App\Filament\Resources\Practitioners\PractitionerResource;
use App\Filament\Resources\Schedules\Schemas\ScheduleForm;
use App\Filament\Resources\Schedules\Tables\SchedulesTable;
use App\Models\Schedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?string $parentResource = PractitionerResource::class;

    /**
     * Scope schedules by their owning organization.
     */
    protected static ?string $tenantOwnershipRelationshipName = 'organizations';

    public static function form(Schema $schema): Schema
    {
        return ScheduleForm::configure($schema, ['practitionerField' => false]);
    }

    public static function table(Table $table): Table
    {
        return SchedulesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
