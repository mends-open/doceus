<?php

use App\Models\Patient;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('encrypts sensitive person attributes', function () {
    $person = Person::factory()->create([
        'first_name' => 'Alice',
    ]);

    $raw = DB::table('people')->where('id', $person->id)->value('first_name');

    expect($raw)->not->toBe('Alice');
    expect($person->fresh()->first_name)->toBe('Alice');
});

it('encrypts patient contact fields', function () {
    $patient = Patient::factory()->create([
        'email' => 'alice@example.com',
        'phone_number' => '+48123123123',
    ]);

    $rawEmail = DB::table('patients')->where('id', $patient->id)->value('email');
    $rawPhone = DB::table('patients')->where('id', $patient->id)->value('phone_number');

    expect($rawEmail)->not->toBe('alice@example.com');
    expect($rawPhone)->not->toBe('+48123123123');

    $patient = $patient->fresh();
    expect($patient->email)->toBe('alice@example.com');
    expect($patient->phone_number)->toBe('+48123123123');
});
