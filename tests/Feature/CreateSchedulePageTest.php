<?php

use App\Filament\Resources\Schedules\Pages\CreateSchedule;
use App\Models\Organization;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

function setTenantForScheduleTests(Organization $organization): void
{
    Filament::setTenant($organization, true);
}

it('shows schedule fields on create schedule page', function () {
    $user = User::factory()->create();
    event(new Login('web', $user, false));
    Livewire::actingAs($user);

    $organization = Organization::factory()->create();
    setTenantForScheduleTests($organization);

    Livewire::test(CreateSchedule::class)
        ->assertFormFieldExists('practitioner_id')
        ->assertFormFieldExists('type')
        ->assertFormFieldExists('start_date')
        ->assertFormFieldExists('start_time')
        ->assertFormFieldExists('days_of_week')
        ->assertFormFieldExists('repeat_pattern');
});
