<?php

namespace App\Filament\Resources\People\Schemas;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\IdentityType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function personalComponents(): array
    {
        return [
            TextInput::make('first_name'),
            TextInput::make('last_name'),
            DatePicker::make('birth_date'),
        ];
    }

    public static function identificationComponents(): array
    {
        return [
            TextInput::make('pesel'),
            TextInput::make('identity_number'),
            Select::make('identity_type')
                ->options(IdentityType::class),
            Select::make('gender')
                ->options(Gender::class),
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->key(null)
                    ->schema(static::personalComponents()),
                Group::make()
                    ->key(null)
                    ->schema(static::identificationComponents()),
            ]);
    }
}
