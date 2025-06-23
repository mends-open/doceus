<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Filament\Resources\People\Schemas\PersonForm;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Patient')
                    ->key(null)
                    ->persistTabInQueryString()
                    ->tabs([
                        Tab::make('Personal')
                            ->key(null)
                            ->schema([
                                Group::make()
                                    ->relationship('person')
                                    ->schema(PersonForm::configure(Schema::make($schema->getLivewire()))->getComponents()),
                            ]),
                        Tab::make('Contact')
                            ->key(null)
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->required(),
                                TextInput::make('phone_number')
                                    ->tel()
                                    ->required(),
                            ]),
                    ]),
            ]);
    }
}
