<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Filament\Resources\People\Schemas\PersonForm;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->statePath('person')
                    ->schema(PersonForm::configure(Schema::make())->getComponents()),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('phone_number')
                    ->tel()
                    ->required(),
            ]);
    }
}
