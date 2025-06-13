<?php

use App\Filament\Resources\Patients\Pages\CreatePatient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('shows patient form fields', function () {
    Livewire::test(CreatePatient::class)
        ->assertFormFieldExists('tag_ids');
});
