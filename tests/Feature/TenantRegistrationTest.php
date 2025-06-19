<?php

use App\Filament\Pages\CreateOrganization;
use App\Models\OrganizationPractitioner;
use App\Models\Person;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('redirects to organization registration when user has none', function () {
    $user = User::factory()->withoutPerson()->create();

    event(new Login('web', $user, false));

    $this->actingAs($user)
        ->get('/')
        ->assertRedirect('/new');
});

it('creates organization and attaches practitioner', function () {
    $user = User::factory()->withoutPerson()->create();
    event(new Login('web', $user, false));

    $user->person->update(Person::factory()->make()->toArray());

    Livewire::actingAs($user)
        ->test(CreateOrganization::class)
        ->fillForm([
            'type' => 'individual',
            'name' => 'Test Org',
        ])
        ->call('register');

    $pivot = OrganizationPractitioner::first();
    expect($pivot)->not->toBeNull();
    expect($pivot->practitioner_id)->toBe($user->practitioner->id);
});

it('redirects to profile page when person incomplete', function () {
    $user = User::factory()->withoutPerson()->create();
    event(new Login('web', $user, false));

    Livewire::actingAs($user)
        ->test(CreateOrganization::class)
        ->assertRedirect(route('filament.app.auth.profile'));
});
