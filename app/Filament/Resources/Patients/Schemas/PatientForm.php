<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Feature\Identity\Enums\ContactPointSystem;
use App\Feature\Identity\Enums\ContactableType;
use App\Feature\Identity\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Models\ContactPoint;
use App\Models\Person;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->relationship('person')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('last_name')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('pesel')
                            ->columnSpanFull(),
                        TextInput::make('id_number')
                            ->columnSpanFull(),
                        Select::make('gender')
                            ->options(Gender::class),
                        DatePicker::make('birth_date'),
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
                    ]),
            ]);
    }
}
