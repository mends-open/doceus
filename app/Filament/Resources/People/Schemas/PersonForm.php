<?php

namespace App\Filament\Resources\People\Schemas;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\IdentityType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name'),
                TextInput::make('last_name'),
                TextInput::make('pesel'),
                TextInput::make('identity_number'),
                Select::make('identity_type')
                    ->options(IdentityType::class),
                Select::make('gender')
                    ->options(Gender::class),
                DatePicker::make('birth_date'),
            ]);
    }
}
