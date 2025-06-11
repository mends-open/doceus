<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Feature\Identity\Enums\ContactPointSystem;
use App\Feature\Identity\Enums\Gender;
use Arr;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PatientForm
{
    /**
     * @throws \Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Group::make()
                    ->columns(3)
                    ->relationship('person')
                    ->schema([
                        TextInput::make('first_name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                        TextInput::make('pesel'),
                        TextInput::make('id_number'),
                        Select::make('gender')
                            ->options(Gender::class),
                        DatePicker::make('birth_date'),
                    ]),
            Repeater::make('email')
                ->simple(TextInput::make('value'))
                ->minItems(1)
                ->defaultItems(1),
            Repeater::make('phone')
                ->simple(TextInput::make('value'))
                ->minItems(1),
            ]);
    }
}
