<?php

namespace App\Filament\Resources\Schedules\Tables;

use App\Feature\Scheduling\Enums\DayOfWeek;
use App\Feature\Scheduling\Enums\ScheduleType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('practitioner.person.first_name')
                    ->label('First name'),
                TextColumn::make('practitioner.person.last_name')
                    ->label('Last name'),
                TextColumn::make('start_date')
                    ->date(),
                TextColumn::make('start_time'),
                TextColumn::make('end_time'),
                TextColumn::make('days_of_week')
                    ->formatStateUsing(fn ($state) => collect($state)->map(fn ($day) => DayOfWeek::from($day)->label())->join(', '))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('repeat_pattern')
                    ->badge(),
                TextColumn::make('type')
                    ->formatStateUsing(fn ($state) => ScheduleType::from($state)->label())
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
