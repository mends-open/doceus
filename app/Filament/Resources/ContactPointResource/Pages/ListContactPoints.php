<?php

namespace App\Filament\Resources\ContactPointResource\Pages;

use App\Filament\Resources\ContactPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactPoints extends ListRecords
{
    protected static string $resource = ContactPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
