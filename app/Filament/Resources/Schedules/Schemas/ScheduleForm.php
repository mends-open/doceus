<?php

namespace App\Filament\Resources\Schedules\Schemas;

use App\Feature\Scheduling\Enums\DayOfWeek;
use App\Models\Location;
use App\Models\Practitioner;
use Filament\Facades\Filament;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;

class ScheduleForm
{
    /**
     * Configure the schedule form schema.
     *
     * @param  array{practitionerField?: bool, locationField?: bool}  $options
     */
    public static function configure(Schema $schema, array $options = []): Schema
    {
        $showPractitioner = $options['practitionerField'] ?? true;
        $showLocation = $options['locationField'] ?? true;

        return $schema
            ->components([
                // allow selecting practitioners from any organization
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
                    ->hidden(! $showPractitioner)
                    ->disabled(! $showPractitioner)
                    ->required($showPractitioner),
                Select::make('location_id')
                    ->options(function () {
                        $tenant = Filament::getTenant();

                        return Location::query()
                            ->when($tenant, fn ($query) => $query->where('organization_id', $tenant->id))
                            ->get()
                            ->mapWithKeys(fn (Location $location) => [
                                $location->id => $location->name ?? 'Location '.$location->id,
                            ])
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->hidden(! $showLocation)
                    ->disabled(! $showLocation)
                    ->required($showLocation),
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
