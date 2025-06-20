<?php

namespace App\Filament\Resources\Schedules\Schemas;

use App\Feature\Scheduling\Enums\DayOfWeek;
use App\Feature\Scheduling\Enums\RepeatPattern;
use App\Feature\Scheduling\Enums\ScheduleType;
use App\Models\Practitioner;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('practitioner_id')
                    ->relationship('practitioner', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Practitioner $record) => $record->person?->first_name.' '.$record->person?->last_name)
                    ->searchable()
                    ->required(),
                Select::make('type')
                    ->options(Collection::make(ScheduleType::cases())->mapWithKeys(fn ($case) => [$case->value => $case->getLabel()])->toArray())
                    ->default(ScheduleType::Standard->value)
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
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
                Select::make('repeat_pattern')
                    ->options(Collection::make(RepeatPattern::cases())->mapWithKeys(fn ($case) => [$case->value => $case->getLabel()])->toArray())
                    ->required(),
            ]);
    }
}
