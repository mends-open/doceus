<?php

namespace App\Filament\Resources\Tags\Schemas;

use App\Feature\Tags\Enums\TagColor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Group;

class TagForm
{
    public static function schema(): array
    {
        return [
            TextInput::make('name')->required(),
            ToggleButtons::make('color')
                ->options(TagColor::class)
                ->enum(TagColor::class)
                ->inline(),
        ];
    }

    /**
     * @throws \Exception
     */
    public static function make(): Group
    {
        return Group::make()->schema(self::schema());
    }
}
