<?php

use App\Http\Middleware\EnsureProfileComplete;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects to profile when person incomplete', function () {
    $user = User::factory()->create();
    $user->person->update(['pesel' => null]);
    event(new Login('web', $user, false));

    $response = $this->actingAs($user)->get('/');

    $response->assertRedirect(route('filament.app.auth.profile'));
});

it('allows access when person complete', function () {
    $user = User::factory()->create();
    event(new Login('web', $user, false));
    $user->createOrganization(\App\Models\Organization::factory()->make()->toArray());

    $response = $this->actingAs($user)->get('/');

    $response->assertStatus(302);
    expect($response->headers->get('Location'))->not->toBe(route('filament.app.auth.profile'));
});
