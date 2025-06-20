<?php

use App\Filament\Auth\Pages\EditProfile;
use App\Models\Practitioner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('shows disabled email and phone fields', function () {
    $practitioner = Practitioner::factory()->create();

    Livewire::actingAs($practitioner)
        ->test(EditProfile::class)
        ->assertFormFieldExists('email')
        ->assertFormFieldDisabled('email')
        ->assertFormFieldExists('phone_number')
        ->assertFormFieldDisabled('phone_number')
        ->assertFormFieldDoesNotExist('password');
});

it('requires pesel and redirects to dashboard after save', function () {
    $practitioner = Practitioner::factory()->create();

    Livewire::actingAs($practitioner)
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
