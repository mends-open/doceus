<?php

namespace Tests\Feature;

use App\Filament\Resources\Patients\Resources\ContactPoints\ContactPointResource;
use App\Models\Organization;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactPointResourceUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_nested_resource_urls_resolve(): void
    {
        $tenant = Organization::factory()->create();
        $patient = Patient::factory()->create();

        $create = ContactPointResource::getUrl('create', [
            'tenant' => $tenant,
            'patient' => $patient,
        ]);

        $edit = ContactPointResource::getUrl('edit', [
            'tenant' => $tenant,
            'patient' => $patient,
            'record' => 1,
        ]);

        $this->assertStringContainsString('/contactpoints/create', $create);
        $this->assertStringContainsString('/contactpoints/1/edit', $edit);
    }
}
