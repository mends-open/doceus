<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('person_id')
                    ->relationship('person', 'id')
                    ->required(),
            ]);
    }
}
