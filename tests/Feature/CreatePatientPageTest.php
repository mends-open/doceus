<?php

use App\Filament\Resources\Patients\Pages\CreatePatient;
use App\Models\Organization;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

function setTenantForTests(Organization $organization): void
{
    Filament::setTenant($organization, true);
}

it('shows person and patient fields on create patient page', function () {
    $user = User::factory()->create();
    event(new Login('web', $user, false));
    Livewire::actingAs($user);

    $organization = Organization::factory()->create();
    setTenantForTests($organization);

    Livewire::test(CreatePatient::class)
        ->assertFormFieldExists('person.first_name')
        ->assertFormFieldExists('person.last_name')
        ->assertFormFieldExists('email')
        ->assertFormFieldExists('phone_number');
});
