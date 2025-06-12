<?php

namespace App\Filament\Resources\Tags\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Feature\Tags\Enums\TagColor;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        $colors = array_column(TagColor::cases(), 'value');

        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description'),
                Select::make('color')
                    ->options(array_combine($colors, array_map('ucfirst', $colors)))
                    ->searchable()
                    ->required(),
            ]);
    }
}
