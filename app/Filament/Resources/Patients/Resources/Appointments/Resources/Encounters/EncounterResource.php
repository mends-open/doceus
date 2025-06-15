<?php

namespace App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters;

use App\Filament\Resources\Patients\Resources\Appointments\AppointmentResource;
use App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\Pages\CreateEncounter;
use App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\Pages\EditEncounter;
use App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\Pages\ViewEncounter;
use App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\Schemas\EncounterForm;
use App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\Schemas\EncounterInfolist;
use App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\Tables\EncountersTable;
use App\Models\Encounter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EncounterResource extends Resource
{
    protected static ?string $model = Encounter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = AppointmentResource::class;

    public static function form(Schema $schema): Schema
    {
        return EncounterForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EncounterInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EncountersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateEncounter::route('/create'),
            'view' => ViewEncounter::route('/{record}'),
            'edit' => EditEncounter::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
