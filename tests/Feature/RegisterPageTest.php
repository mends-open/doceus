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
