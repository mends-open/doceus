<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Feature\Identity\Enums\ContactPointSystem;
use App\Feature\Identity\Enums\ContactableType;
use App\Feature\Identity\Enums\Gender;
use App\Models\ContactPoint;
use App\Models\Person;
use Illuminate\Database\Eloquent\Builder;
                            ->required()
                            ->columnSpanFull(),
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('pesel')
                            ->columnSpanFull(),
                        TextInput::make('id_number')
                            ->columnSpanFull(),
                        Select::make('emails')
                            ->label('Emails')
                            ->relationship(
                                'emails',
                                'value',
                                modifyQueryUsing: function (Builder $query, ?string $search, ?Person $record) {
                                    $query
                                        ->where('system', ContactPointSystem::Email)
                                        ->where(function ($q) use ($record) {
                                            $q->whereNull('contactable_id');
                                            if ($record) {
                                                $q->orWhere('contactable_id', $record->id);
                                            }
                                        });
                                },
                                ignoreRecord: true,
                            )
                            ->createOptionForm([
                                TextInput::make('value')
                                    ->label('Email')
                                    ->required(),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                $data['system'] = ContactPointSystem::Email->value;
                                $data['contactable_type'] = ContactableType::Person->value;

                                return ContactPoint::create($data)->getKey();
                            })
                            ->multiple()
                            ->preload(),
                        Select::make('phones')
                            ->label('Phones')
                            ->relationship(
                                'phones',
                                'value',
                                modifyQueryUsing: function (Builder $query, ?string $search, ?Person $record) {
                                    $query
                                        ->where('system', ContactPointSystem::Phone)
                                        ->where(function ($q) use ($record) {
                                            $q->whereNull('contactable_id');
                                            if ($record) {
                                                $q->orWhere('contactable_id', $record->id);
                                            }
                                        });
                                },
                                ignoreRecord: true,
                            )
                            ->createOptionForm([
                                TextInput::make('value')
                                    ->label('Phone')
                                    ->required(),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                $data['system'] = ContactPointSystem::Phone->value;
                                $data['contactable_type'] = ContactableType::Person->value;

                                return ContactPoint::create($data)->getKey();
                            })
                            ->multiple()
                            ->preload(),
        return $schema
            ->columns(1)
            ->components([
                Group::make()
                    ->columns(3)
                    ->relationship('person')
                    ->schema([
                        TextInput::make('first_name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                        TextInput::make('pesel'),
                        TextInput::make('id_number'),
                        ToggleButtons::make('gender')
                            ->inline()
                            ->options(Gender::class),
                        DatePicker::make('birth_date'),
                        Repeater::make('emails')
                            ->simple(TextInput::make('value'))
                            ->minItems(1)
                            ->defaultItems(1),
                        Repeater::make('phone_numbers')
                            ->simple(TextInput::make('value'))
                            ->minItems(1)
                            ->defaultItems(1)
                ]),
            ]);
    }
}
