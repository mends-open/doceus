<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Feature\Identity\Enums\Gender;
use App\Models\Patient;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\ToggleButtons;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PatientForm
{
    /**
     * @throws \Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Flex::make([
                    Group::make()
                    ->relationship('person')
                    ->schema([
                        Tabs::make()
                        ->tabs([
                            Tab::make('Personal Information')
                            ->schema([
                                TextInput::make('first_name')
                                    ->required(),
                                TextInput::make('last_name')
                                    ->required(),
                                TextInput::make('pesel'),
                                TextInput::make('id_number'),
                                ToggleButtons::make('gender')
                                    ->options(Gender::class)
                                    ->enum(Gender::class)
                                    ->colors([
                                        Gender::Male->value => 'success',
                                        Gender::Female->value => 'sky',
                                    ]),
                                DatePicker::make('birth_date'),
                            ]),
                            Tab::make('Contact Information')
                            ->schema([
                                TextInput::make('email')
                                    ->email(),
                                TextInput::make('phone_number'),
                            ])
                        ]),
                    ]),
                    Group::make()
                    ->grow(false)
                    ->schema([
                        ToggleButtons::make('tag_ids')
                            ->multiple()
                            ->default(fn (?Patient $record) => $record?->tags->pluck('id')->map(fn ($id) => (string) $id)->all())
                            ->options(fn () => \App\Models\Tag::pluck('name', 'id')->toArray())
                            ->icons(fn () => \App\Models\Tag::all()->mapWithKeys(fn ($tag) => [$tag->id => Heroicon::from($tag->icon)])->toArray())
                            ->colors(fn () => \App\Models\Tag::pluck('color', 'id')->toArray()),
                    ])
                ])
            ]);
    }
}
