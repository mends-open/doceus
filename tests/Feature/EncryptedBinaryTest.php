<?php

use App\Models\Organization;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('encrypts person fields as binary', function () {
    $person = Person::factory()->create(['first_name' => 'Alice']);

    $raw = DB::table('people')->where('id', $person->id)->first()->first_name;

    expect($person->first_name)->toBe('Alice')
        ->and($raw)->not->toBe('Alice')
        ->and(base64_encode($raw))->not->toBe($raw);
});

it('encrypts organization name as binary', function () {
    $org = Organization::factory()->create(['name' => 'Clinic']);

    $raw = DB::table('organizations')->where('id', $org->id)->value('name');

    expect($org->name)->toBe('Clinic')
        ->and($raw)->not->toBe('Clinic')
        ->and(base64_encode($raw))->not->toBe($raw);
});
