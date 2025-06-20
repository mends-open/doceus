<?php

use App\Models\Practitioner;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects to email verification when not verified', function () {
    $practitioner = Practitioner::factory()->unverified()->create();

    $response = $this->actingAs($practitioner)->get('/');

    $response->assertRedirect(route('filament.app.auth.email-verification.prompt'));
});

it('allows access when verified', function () {
    $practitioner = Practitioner::factory()->create();

    $response = $this->actingAs($practitioner)->get('/');

    $response->assertStatus(302);
    expect($response->headers->get('Location'))->not->toBe(route('filament.app.auth.email-verification.prompt'));
});

it('allows email verification prompt for unverified user', function () {
    $practitioner = Practitioner::factory()->unverified()->create();

    $response = $this->actingAs($practitioner)->get(route('filament.app.auth.email-verification.prompt'));

    $response->assertSuccessful();
});
