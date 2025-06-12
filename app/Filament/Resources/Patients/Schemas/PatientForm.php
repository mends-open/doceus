<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Filament\Resources\Tags\Schemas\TagSelector;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Flex::make([
                    PersonForm::make(),
                    TagSelector::make(),
                ]),
            ]);
    }
}
