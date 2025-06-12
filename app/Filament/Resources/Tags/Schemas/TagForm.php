<?php

namespace App\Filament\Resources\Tags\Schemas;

use App\Feature\Tags\Enums\TagColor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Group;

class TagForm
{
    /**
     * @throws \Exception
     */
    public static function make(): Group
    {
        return Group::make()
            ->schema([
                TextInput::make('name')->required(),
                ToggleButtons::make('color')
                    ->options(TagColor::class)
                    ->enum(TagColor::class)
                    ->inline(),
            ]);
    }
}
