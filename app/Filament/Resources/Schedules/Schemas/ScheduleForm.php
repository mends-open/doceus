<?php

namespace App\Filament\Resources\Schedules\Schemas;

use App\Feature\Scheduling\Enums\DayOfWeek;
use App\Models\Practitioner;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // temporary: allow selecting practitioners from any organization
                Select::make('practitioner_id')
                    ->options(
                        Practitioner::with('person')->get()->mapWithKeys(
                            fn (Practitioner $practitioner) => [
                                $practitioner->id => $practitioner->person?->first_name.' '.$practitioner->person?->last_name,
                            ],
                        )
                            ->toArray()
                    )
                    ->searchable()
                    ->required(),
                Select::make('location_id')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->required(),
                Builder::make('entries')
                    ->required()
                    ->blocks([
                        Block::make('weekly')
                            ->schema([
                                DatePicker::make('start_date')->required(),
                                Toggle::make('has_end_date')->live(),
                                DatePicker::make('end_date')
                                    ->hidden(fn (Get $get) => ! $get('has_end_date')),
                                TimePicker::make('start_time')->seconds(false)->required(),
                                TimePicker::make('end_time')->seconds(false)->required(),
                                CheckboxList::make('days')
                                    ->options(Collection::make(DayOfWeek::cases())->mapWithKeys(fn ($case) => [$case->value => $case->getLabel()]))
                                    ->columns(2)
                                    ->required(),
                            ]),
                        Block::make('one_time')
                            ->schema([
                                DatePicker::make('date')->required(),
                                TimePicker::make('start_time')->seconds(false)->required(),
                                TimePicker::make('end_time')->seconds(false)->required(),
                            ]),
                        Block::make('block')
                            ->schema([
                                DatePicker::make('date')->required(),
                                Toggle::make('full_day')->live(),
                                TimePicker::make('start_time')->seconds(false)->required()->hidden(fn (Get $get) => $get('full_day')),
                                TimePicker::make('end_time')->seconds(false)->required()->hidden(fn (Get $get) => $get('full_day')),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
