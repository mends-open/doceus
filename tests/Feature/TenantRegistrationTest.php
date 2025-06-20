<?php

use App\Filament\Pages\CreateOrganization;
use App\Models\OrganizationPractitioner;
use App\Models\Person;
use App\Models\Practitioner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('redirects to organization registration when user has none', function () {
    $practitioner = Practitioner::factory()->create();

    $practitioner->person->update(Person::factory()->make()->toArray());

    $this->actingAs($practitioner)
        ->get('/')
        ->assertRedirect('/new');
});

it('creates organization and attaches practitioner', function () {
    $practitioner = Practitioner::factory()->create();

    $practitioner->person->update(Person::factory()->make()->toArray());

    Livewire::actingAs($practitioner)
        ->test(CreateOrganization::class)
        ->fillForm([
            'type' => 'individual',
            'name' => 'Test Org',
        ])
        ->call('register');

    $pivot = OrganizationPractitioner::first();
    expect($pivot)->not->toBeNull();
    expect($pivot->practitioner_id)->toBe($practitioner->id);
});

it('redirects to profile page when person incomplete', function () {
    $practitioner = Practitioner::factory()->create();
    $practitioner->person->update(['pesel' => null]);

    Livewire::actingAs($practitioner)
        ->test(CreateOrganization::class)
        ->assertRedirect(route('filament.app.auth.profile'));
});
