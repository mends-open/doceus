<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Feature\Identity\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Group;
use Filament\Support\Enums\Width;

class PersonForm
{
    /**
     * @throws \Exception
     */
    public static function make(): Group
    {
        return Group::make()
            ->relationship('person')
            ->schema([
                Tabs::make()
                    ->columns(2)
                    ->tabs([
                        Tab::make('Personal Information')
                            ->schema([
                                TextInput::make('first_name')->required(),
                                TextInput::make('last_name')->required(),
                                TextInput::make('pesel'),
                                TextInput::make('id_number'),
                                ToggleButtons::make('gender')
                                    ->options(Gender::class)
                                    ->enum(Gender::class)
                                    ->inline()
                                    ->colors([
                                        Gender::Male->value => 'success',
                                        Gender::Female->value => 'sky',
                                    ]),
                                DatePicker::make('birth_date'),
                            ]),
                        Tab::make('Contact Information')
                            ->schema([
                                TextInput::make('email')->email(),
                                TextInput::make('phone_number'),
                            ]),
                    ]),
            ]);
    }
}
