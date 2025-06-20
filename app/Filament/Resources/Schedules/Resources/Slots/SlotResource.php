<?php

namespace App\Filament\Resources\Schedules\Resources\Slots;

use App\Filament\Resources\Schedules\Resources\Slots\Pages\CreateSlot;
use App\Filament\Resources\Schedules\Resources\Slots\Pages\EditSlot;
use App\Filament\Resources\Schedules\Resources\Slots\Schemas\SlotForm;
use App\Filament\Resources\Schedules\Resources\Slots\Tables\SlotsTable;
use App\Filament\Resources\Schedules\ScheduleResource;
use App\Models\Slot;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SlotResource extends Resource
{
    protected static ?string $model = Slot::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = ScheduleResource::class;

    public static function form(Schema $schema): Schema
    {
        return SlotForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SlotsTable::configure($table);
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
            'create' => CreateSlot::route('/create'),
            'edit' => EditSlot::route('/{record}/edit'),
        ];
    }
}
