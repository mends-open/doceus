<?php

namespace App\Filament\Resources\Patients\Resources\Appointments\Resources\Encounters\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EncounterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('notes')
                    ->columnSpan('full'),
            ]);
    }
}
