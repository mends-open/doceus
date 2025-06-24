<?php

namespace App\Filament\Resources\Practitioners\Schemas;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\IdentityType;
use Exception;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Image;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Livewire\Attributes\Renderless;
use Str;

class PractitionerForm
{
    /**
     * @throws Exception
     */
    #[Renderless] // ← no re-render after this method
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make()
                    ->columns(13)
                    ->schema([
                        Group::make([
                        ])
                            ->columnSpan(2),
                        Section::make('personal')
                            ->extraAttributes(['wire:ignore'])
                            ->schema([
                                TextInput::make('first_name')
                                    ->debounce()
                                    ->afterStateUpdated(
                                        fn ($livewire, $component) => $livewire->saveComponent($component)
                                    ),
                                TextInput::make('last_name')
                                    ->debounce()
                                    ->afterStateUpdated(
                                        fn ($livewire, $component) => $livewire->saveComponent($component)
                                    ),
                            ])
                            ->columns(2)
                            ->columnSpan(8)
                            ->relationship('person'),
                        Group::make([
                            Image::make('https://placehold.co/600x400', 'test'),
                            Text::make(
                                fn ($record) => Str::of($record->person->first_name)
                                    ->append(' ')
                                    ->append($record->person->last_name)
                                    ->toString(),   // make it a plain string for Filament
                            )
                                ->size(TextSize::Large),
                        ])
                            ->columnSpan(3),
                        Section::make('identity')
                            ->columnStart(3)
                            ->columnSpan(8)
                            ->schema([
                                TextInput::make('pesel'),
                                TextInput::make('identity_number'),
                                Select::make('identity_type')
                                    ->options(IdentityType::class),
                                ToggleButtons::make('gender')
                                    ->inline()
                                    ->options(Gender::class),
                            ])
                            ->columns(2)
                            ->relationship('person'),
                        Section::make('contact')
                            ->columnStart(3)
                            ->columnSpan(8)
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->required(),
                                TextInput::make('phone_number')
                                    ->tel(),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }
}
