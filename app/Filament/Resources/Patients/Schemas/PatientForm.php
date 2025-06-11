<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\ContactPointSystem;
use App\Models\Patient;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Section;
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
                    Section::make()
                    ->relationship('person')
                    ->schema([
                        TextInput::make('first_name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                        TextInput::make('pesel'),
                        TextInput::make('id_number'),
                        Select::make('gender')
                            ->options(Gender::class),
                        DatePicker::make('birth_date'),
                    ]),
                    Section::make()
                    ->schema([
                        Repeater::make('emails')
                            ->relationship('emails')
                            ->deletable(false)
                            ->modifyAddActionUsing(fn(Action $action) => $action->extraAttributes(['x-ref' => 'addButton']))
                            ->simple(
                                TextInput::make('value')
                                    ->live()
                                    ->extraInputAttributes(['x-on:keydown.enter.stop.prevent' => '$refs.addButton.click()'])
                                    ->afterStateUpdated(function (TextInput $component, Set $set, ?string $state): void {
                                        if (blank($state)) {
                                            $repeater = $component->getParentRepeater();
                                            if (! $repeater) {
                                                return;
                                            }

                                            $repeaterPath = $repeater->getStatePath();
                                            $componentItemStatePath = (string) str($component->getStatePath())
                                                ->after("{$repeaterPath}.")
                                                ->after('.');
                                            $itemKey = (string) str($component->getStatePath())
                                                ->after("{$repeaterPath}.")
                                                ->beforeLast(".{$componentItemStatePath}");

                                            $items = $repeater->getRawState();
                                            unset($items[$itemKey]);

                                            $set($repeaterPath, $items);
                                        }
                                    }),
                            )
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                $data['system'] = ContactPointSystem::Email;

                                return $data;
                            })
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                $data['system'] = ContactPointSystem::Email;

                                return $data;
                            }),
                        Repeater::make('phones')
                            ->relationship('phones')
                            ->deletable(false)
                            ->modifyAddActionUsing(fn(Action $action) => $action->extraAttributes(['x-ref' => 'addButton']))
                            ->simple(
                                TextInput::make('value')
                                    ->live()
                                    ->extraInputAttributes(['x-on:keydown.enter.stop.prevent' => '$refs.addButton.click()'])
                                    ->afterStateUpdated(function (TextInput $component, Set $set, ?string $state): void {
                                        if (blank($state)) {
                                            $repeater = $component->getParentRepeater();
                                            if (! $repeater) {
                                                return;
                                            }

                                            $repeaterPath = $repeater->getStatePath();
                                            $componentItemStatePath = (string) str($component->getStatePath())
                                                ->after("{$repeaterPath}.")
                                                ->after('.');
                                            $itemKey = (string) str($component->getStatePath())
                                                ->after("{$repeaterPath}.")
                                                ->beforeLast(".{$componentItemStatePath}");

                                            $items = $repeater->getRawState();
                                            unset($items[$itemKey]);

                                            $set($repeaterPath, $items);
                                        }
                                    }),
                            )
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                $data['system'] = ContactPointSystem::Phone;

                                return $data;
                            })
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                $data['system'] = ContactPointSystem::Phone;

                                return $data;
                            }),
                    ])
                ])
            ]);
    }
}
