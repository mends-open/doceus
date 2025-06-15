<?php

namespace App\Filament\Resources\Patients\Resources\Appointments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('patient_id')
                    ->relationship('patient', 'id')
                    ->required(),
                Select::make('practitioner_id')
                    ->relationship('practitioner', 'id')
                    ->required(),
                Select::make('organization_id')
                    ->relationship('organization', 'id')
                    ->required(),
                DateTimePicker::make('scheduled_at')
                    ->required(),
            ]);
    }
}
