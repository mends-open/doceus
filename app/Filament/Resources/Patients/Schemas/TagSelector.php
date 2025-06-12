<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Models\Patient;
use App\Models\Tag;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Group;

class TagSelector
{
    public static function make(): Group
    {
        return Group::make()
            ->grow(false)
            ->schema([
                ToggleButtons::make('tag_ids')
                    ->multiple()
                    ->inline()
                    ->default(fn (?Patient $record) => $record?->tags->pluck('id')->map(fn ($id) => (string) $id)->all())
                    ->options(fn () => Tag::pluck('name', 'id')->toArray())
                    ->colors(fn () => Tag::pluck('color', 'id')->toArray()),
            ]);
    }
}
