<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Feature\Identity\Enums\Gender;
use App\Models\Patient;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
            ->columns(1)
            ->components([
                Flex::make([
                    Section::make()
                    ->relationship('person')
                    ->schema([
                        TextInput::make('first_name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                        TextInput::make('pesel'),
                        TextInput::make('id_number'),
                        TextInput::make('email')
                            ->email(),
                        TextInput::make('phone_number'),
                        Select::make('gender')
                            ->options(Gender::class),
                        DatePicker::make('birth_date'),
                    ]),
                    Section::make()
                    ->label('Additional Contacts')
                    ->schema([
                        Repeater::make('extra_contacts')
                            ->statePath('extra_contacts')
                            ->simple(
                                Group::make([
                                    Select::make('system')
                                        ->options([
                                            'email' => 'Email',
                                            'phone' => 'Phone',
                                            'other' => 'Other',
                                        ]),
                                    TextInput::make('value'),
                                ])
                            ),
                    ])
                ])
            ]);
    }
}
