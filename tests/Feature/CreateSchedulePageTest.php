<?php

use App\Filament\Resources\Schedules\Pages\CreateSchedule;
use App\Models\Organization;
use App\Models\Practitioner;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

function setTenantForScheduleTests(Organization $organization): void
{
    Filament::setTenant($organization, true);
}

it('shows schedule fields on create schedule page', function () {
    $practitioner = Practitioner::factory()->create();
    Livewire::actingAs($practitioner);

    $organization = Organization::factory()->create();
    setTenantForScheduleTests($organization);

    Livewire::test(CreateSchedule::class)
        ->assertFormFieldExists('practitioner_id')
        ->assertFormFieldExists('location_id')
        ->assertFormFieldExists('entries');
});
