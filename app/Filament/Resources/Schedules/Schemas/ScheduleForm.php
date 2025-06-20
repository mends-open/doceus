<?php

namespace App\Filament\Resources\Schedules\Schemas;

use App\Feature\Scheduling\Enums\DayOfWeek;
use App\Models\Practitioner;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
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
                Toggle::make('is_blocking')
                    ->label('Blocking entry'),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('repeat_until'),
                TimePicker::make('start_time')
                    ->seconds(false)
                    ->required(),
                TimePicker::make('end_time')
                    ->seconds(false)
                    ->required(),
                CheckboxList::make('days_of_week')
                    ->options(Collection::make(DayOfWeek::cases())->mapWithKeys(fn ($case) => [$case->value => $case->getLabel()])->toArray())
                    ->columns(2)
                    ->required(),
            ]);
    }
}
