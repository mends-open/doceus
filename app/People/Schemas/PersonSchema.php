<?php

namespace App\People\Schemas;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\IdentityType;
use App\Feature\Identity\Rules\ValidPesel;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PersonSchema extends Schema
{
    public function configure(): static
    {
        return $this->schema([
            TextInput::make('first_name')
                ->label(__('doceus.user.first_name'))
                ->required(),
            TextInput::make('last_name')
                ->label(__('doceus.user.last_name'))
                ->required(),
            TextInput::make('pesel')
                ->label(__('doceus.user.pesel'))
                ->required()
                ->rule(new ValidPesel),
            TextInput::make('identity_number')
                ->label(__('doceus.id_number')),
            Select::make('identity_type')
                ->label('Identity Type')
                ->options(collect(IdentityType::cases())->mapWithKeys(fn ($case) => [$case->value => $case->value])),
            Select::make('gender')
                ->label(__('doceus.gender.label'))
                ->options(Gender::class),
            DatePicker::make('birth_date')
                ->label(__('doceus.birth_date')),
        ]);
    }
}
