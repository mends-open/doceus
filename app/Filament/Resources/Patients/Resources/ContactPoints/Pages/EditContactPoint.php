<?php

namespace App\Filament\Resources\Patients\Resources\ContactPoints\Pages;

use App\Filament\Resources\Patients\Resources\ContactPoints\ContactPointResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditContactPoint extends EditRecord
{
    protected static string $resource = ContactPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
