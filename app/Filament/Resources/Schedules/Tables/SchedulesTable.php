<?php

namespace App\Filament\Resources\Schedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
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
                TextColumn::make('practitioners.person.first_name')
                    ->label('Practitioner')
                    ->formatStateUsing(fn ($state, $record) => $record->practitioners->first()?->person?->first_name.' '.$record->practitioners->first()?->person?->last_name),
                TextColumn::make('locations.name')
                    ->label('Location')
                    ->formatStateUsing(fn ($state, $record) => $record->locations->first()?->name),
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
            ->headerActions([
                CreateAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
