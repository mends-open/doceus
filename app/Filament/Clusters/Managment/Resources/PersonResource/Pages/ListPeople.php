<?php

namespace App\Filament\Clusters\Managment\Resources\PersonResource\Pages;

use App\Filament\Clusters\Managment\Resources\PersonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeople extends ListRecords
{
    protected static string $resource = PersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
