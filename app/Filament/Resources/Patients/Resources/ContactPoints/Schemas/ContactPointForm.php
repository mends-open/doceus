<?php

namespace App\Filament\Resources\Patients\Resources\ContactPoints\Schemas;

use Filament\Schemas\Schema;
use App\Feature\Identity\Enums\ContactPointSystem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ContactPointForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('system')
                    ->options(ContactPointSystem::class)
                    ->required(),
                TextInput::make('value')
                    ->required(),
            ]);
    }
}
