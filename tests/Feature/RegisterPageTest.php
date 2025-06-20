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

    $practitioner = \App\Models\Practitioner::where('email', 'new@example.com')->first();
    expect($practitioner)->not->toBeNull();
    expect($practitioner->person)->not->toBeNull();
});
