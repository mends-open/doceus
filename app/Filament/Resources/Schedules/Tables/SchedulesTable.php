<?php

namespace App\Filament\Resources\Schedules\Tables;

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
                TextColumn::make('location.name')
                    ->label('Location'),
                TextColumn::make('entries')
                    ->label('Entries')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) : 0),
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
