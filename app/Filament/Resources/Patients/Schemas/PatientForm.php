<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Feature\Identity\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->relationship('person')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('last_name')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('pesel')
                            ->columnSpanFull(),
                        TextInput::make('id_number')
                            ->columnSpanFull(),
                        Select::make('gender')
                            ->options(Gender::class),
                        DatePicker::make('birth_date'),
                    ]),
            ]);
    }
}
