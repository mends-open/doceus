<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\IdentityType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PatientForm
{
    /**
     * @throws \Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('first_name'),
                    TextInput::make('last_name'),
                ])
                    ->relationship('person'),
                Section::make([
                    TextInput::make('pesel'),
                    TextInput::make('identity_number'),
                    Select::make('identity_type')
                        ->options(IdentityType::class),
                    ToggleButtons::make('gender')
                        ->inline()
                        ->options(Gender::class),
                ])
                    ->relationship('person'),
                Section::make([
                    TextInput::make('email')
                        ->email()
                        ->required(),
                    TextInput::make('phone_number')
                        ->tel(),
                ]),
            ]);
    }
}
