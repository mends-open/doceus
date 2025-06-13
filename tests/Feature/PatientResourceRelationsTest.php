<?php

use App\Filament\Resources\Patients\PatientResource;
use App\Filament\Resources\Patients\RelationManagers\TagsRelationManager;

it('registers tags relation manager', function () {
    expect(PatientResource::getRelations())
        ->toContain(TagsRelationManager::class);
});
