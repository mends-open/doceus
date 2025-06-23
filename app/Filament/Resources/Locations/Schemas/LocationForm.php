<?php

namespace App\Filament\Resources\Locations\Schemas;

use App\Feature\Identity\Enums\LocationType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Location')
                    ->tabs([
                        Tab::make('General')
                            ->schema([
                                TextInput::make('name'),
                                Select::make('type')
                                    ->options(LocationType::class)
                                    ->default('virtual')
                                    ->required(),
                            ]),
                        Tab::make('Details')
                            ->schema([
                                TextInput::make('address'),
                                TextInput::make('description'),
                            ]),
                    ]),
            ]);
    }
}
