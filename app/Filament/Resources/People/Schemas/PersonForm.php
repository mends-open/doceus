<?php

namespace App\Filament\Resources\People\Schemas;

use App\Feature\Identity\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ]);
    }
}
