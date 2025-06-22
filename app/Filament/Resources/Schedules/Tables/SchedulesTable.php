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
                TextColumn::make('practitioner')
                    ->label('Practitioner')
                    ->state(fn ($record) => $record->practitioners->first()?->person?->first_name.' '.$record->practitioners->first()?->person?->last_name)
                    ->searchable(),
                TextColumn::make('location')
                    ->label('Location')
                    ->state(fn ($record) => $record->locations->first()?->name)
                    ->searchable(),
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
