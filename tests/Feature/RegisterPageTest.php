<?php

use App\Filament\Auth\Pages\Register;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('shows email and phone fields on register page', function () {
    Livewire::test(Register::class)
        ->assertFormFieldExists('email')
        ->assertFormFieldExists('phone_number');
});

it('creates person record when registering', function () {
    Livewire::test(Register::class)
        ->fillForm([
            'email' => 'new@example.com',
            'phone_number' => '+48123123123',
            'password' => 'password',
            'passwordConfirmation' => 'password',
        ])
        ->call('register');

    $user = \App\Models\User::where('email', 'new@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->person)->not->toBeNull();
});
