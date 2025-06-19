<?php

use App\Filament\Auth\Pages\EditProfile;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('shows disabled email and phone fields', function () {
    $user = User::factory()->create();
    event(new Login('web', $user, false));

    Livewire::actingAs($user)
        ->test(EditProfile::class)
        ->assertFormFieldExists('email')
        ->assertFormFieldDisabled('email')
        ->assertFormFieldExists('phone_number')
        ->assertFormFieldDisabled('phone_number')
        ->assertFormFieldDoesNotExist('password');
});

it('requires pesel and redirects to dashboard after save', function () {
    $user = User::factory()->create();
    event(new Login('web', $user, false));

    Livewire::actingAs($user)
        ->test(EditProfile::class)
        ->fillForm([
            'language' => 'en',
            'person' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'pesel' => '44051401359',
            ],
        ])
        ->call('save')
        ->assertRedirect('/');
});
