<?php

use App\Feature\Identity\Enums\Language;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('defaults to English when configured locale is invalid', function () {
    config(['app.locale' => 'fr_FR']);

    $user = User::factory()->make(['language' => null]);

    expect($user->language)->toBe(Language::English);
});
