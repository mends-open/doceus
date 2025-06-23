<?php

namespace App\Filament\Resources\Practitioners\Schemas;

use App\Feature\Identity\Enums\Language;
use App\Filament\Resources\People\Schemas\PersonForm;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PractitionerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Practitioner')
                    ->key(null)
                    ->persistTabInQueryString()
                    ->tabs([
                        Tab::make('Personal')
                            ->key(null)
                            ->schema([
                                Group::make()
                                    ->relationship('person')
                                    ->schema(PersonForm::personalComponents()),
                            ]),
                        Tab::make('Identification')
                            ->key(null)
                            ->schema([
                                Group::make()
                                    ->relationship('person')
                                    ->schema(PersonForm::identificationComponents()),
                            ]),
                        Tab::make('Contact')
                            ->key(null)
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->required(),
                                TextInput::make('phone_number')
                                    ->tel(),
                                Select::make('language')
                                    ->options(Language::class),
                            ]),
                    ]),
            ]);
    }
}
