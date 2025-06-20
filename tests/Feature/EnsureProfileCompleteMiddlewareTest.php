<?php

use App\Http\Middleware\EnsureProfileComplete;
use App\Models\Practitioner;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects to profile when person incomplete', function () {
    $practitioner = Practitioner::factory()->create();
    $practitioner->person->update(['pesel' => null]);

    $response = $this->actingAs($practitioner)->get('/');

    $response->assertRedirect(route('filament.app.auth.profile'));
});

it('allows access when person complete', function () {
    $practitioner = Practitioner::factory()->create();
    $practitioner->createOrganization(\App\Models\Organization::factory()->make()->toArray());

    $response = $this->actingAs($practitioner)->get('/');

    $response->assertStatus(302);
    expect($response->headers->get('Location'))->not->toBe(route('filament.app.auth.profile'));
});

it('allows email verification prompt when not verified', function () {
    $practitioner = Practitioner::factory()->unverified()->create();
    $practitioner->person->update(['pesel' => null]);

    $response = $this->actingAs($practitioner)->get(route('filament.app.auth.email-verification.prompt'));

    $response->assertSuccessful();
});
