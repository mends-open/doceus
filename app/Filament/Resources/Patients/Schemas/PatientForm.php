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
                            ->addAction(fn($action) => $action->extraAttributes(['x-ref' => 'addButton']))
                            ->simple(
                                TextInput::make('value')
                                    ->extraInputAttributes([
                                        'x-on:keydown.enter.stop.prevent' => '$refs.addButton.click(); $nextTick(() => { const inputs = $el.closest(\'.fi-fo-repeater\').querySelectorAll(\'input\'); inputs[inputs.length - 1]?.focus(); })',
                                        'x-on:input.debounce.200ms' => "if ($el.value === '') { const parts = $statePath.split('.'); parts.pop(); const index = parts.pop(); const repeaterPath = parts.join('.'); const items = $get(repeaterPath) ?? []; items.splice(index, 1); $set(repeaterPath, items); }",
                                    ])
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
                            ->addAction(fn($action) => $action->extraAttributes(['x-ref' => 'addButton']))
                            ->simple(
                                TextInput::make('value')
                                    ->extraInputAttributes([
                                        'x-on:keydown.enter.stop.prevent' => '$refs.addButton.click(); $nextTick(() => { const inputs = $el.closest(\'.fi-fo-repeater\').querySelectorAll(\'input\'); inputs[inputs.length - 1]?.focus(); })',
                                        'x-on:input.debounce.200ms' => "if ($el.value === '') { const parts = $statePath.split('.'); parts.pop(); const index = parts.pop(); const repeaterPath = parts.join('.'); const items = $get(repeaterPath) ?? []; items.splice(index, 1); $set(repeaterPath, items); }",
                                    ])
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
