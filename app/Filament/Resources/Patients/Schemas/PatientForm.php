<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Feature\Identity\Enums\ContactPointSystem;
use App\Feature\Identity\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
                        Textarea::make('first_name')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('last_name')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('pesel')
                            ->columnSpanFull(),
                        Textarea::make('id_number')
                            ->columnSpanFull(),
                        Select::make('gender')
                            ->options(Gender::class),
                        DatePicker::make('birth_date'),
                        Repeater::make('contactPoints')
                            ->relationship()
                            ->schema([
                                Select::make('system')
                                    ->options(ContactPointSystem::class)
                                    ->required(),
                                TextInput::make('value')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }
}
