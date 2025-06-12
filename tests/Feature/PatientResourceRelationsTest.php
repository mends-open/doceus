<?php

namespace Tests\Feature;

use App\Filament\Resources\Patients\PatientResource;
use App\Filament\Resources\Patients\RelationManagers\TagsRelationManager;
use Tests\TestCase;

class PatientResourceRelationsTest extends TestCase
{
    public function test_tags_relation_manager_is_registered(): void
    {
        $this->assertContains(
            TagsRelationManager::class,
            PatientResource::getRelations(),
        );
    }
}
