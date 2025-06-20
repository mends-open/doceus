<?php

namespace App\Filament\Resources\Locations\Schemas;

use App\Feature\Identity\Enums\LocationType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                Select::make('type')
                    ->options(LocationType::class)
                    ->default('virtual')
                    ->required(),
                TextInput::make('address'),
                TextInput::make('description'),
            ]);
    }
}
