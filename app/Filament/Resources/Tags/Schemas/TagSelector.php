<?php

namespace App\Filament\Resources\Tags\Schemas;

use App\Feature\Tags\Enums\TagColor;
use App\Models\Patient;
use App\Models\Tag;
use BackedEnum;
use App\Filament\Resources\Tags\Schemas\TagForm;
use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Group;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class TagSelector
{
    /**
     * @throws \Exception
     */
    public static function make(): Group
    {
        return Group::make()
            ->grow(false)
            ->schema([
                Toggle::make('show_selected_only')
                    ->label('Show selected only')
                    ->dehydrated(false)
                    ->live(),
                ToggleButtons::make('tag_ids')
                    ->maxWidth(Width::ExtraSmall)
                    ->multiple()
                    ->inline()
                    ->afterContent(
                        Action::make('createTag')
                            ->icon(Heroicon::Plus)
                            ->iconButton()
                            ->form(TagForm::schema())
                            ->action(function (array $data, Get $get, Set $set) {
                                $organization = filament()->getTenant();

                                $tag = Tag::create([
                                    'organization_id' => $organization->id,
                                    'name' => $data['name'],
                                    'color' => $data['color'],
                                ]);

                                $set('tag_ids', array_merge($get('tag_ids') ?? [], [(string) $tag->id]));
                            })
                    )
                    ->default(fn (?Patient $record) => $record?->tags
                        ->pluck('id')
                        ->map(fn (int $id) => (string) $id)
                        ->all())
                    ->options(fn (Get $get) => Tag::query()
                        ->when($get('show_selected_only'), function ($query) use ($get) {
                            $query->whereIn('id', $get('tag_ids') ?? []);
                        })
                        ->get()
                        ->mapWithKeys(fn (Tag $tag) => [
                            (string) $tag->id => $tag->name,
                        ])->toArray())
                    ->colors(fn (Get $get) => Tag::query()
                        ->when($get('show_selected_only'), function ($query) use ($get) {
                            $query->whereIn('id', $get('tag_ids') ?? []);
                        })
                        ->get()
                        ->mapWithKeys(fn (Tag $tag) => [
                            (string) $tag->id => $tag->color instanceof BackedEnum
                                ? $tag->color->value
                                : $tag->color,
                        ])->toArray()),
            ]);
    }
}
