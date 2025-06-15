<?php

use App\Models\Organization;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Casts\EncryptedBinary;

uses(RefreshDatabase::class);

it('encrypts person fields as binary', function () {
    $person = Person::factory()->create(['first_name' => 'Alice']);

    $raw = DB::table('people')->where('id', $person->id)->first()->first_name;

    expect($person->first_name)->toBe('Alice')
        ->and($raw)->not->toBe('Alice')
        ->and(Crypt::decrypt($raw))->toBe('Alice');
});

it('encrypts organization name as binary', function () {
    $org = Organization::factory()->create(['name' => 'Clinic']);

    $raw = DB::table('organizations')->where('id', $org->id)->value('name');

    expect($org->name)->toBe('Clinic')
        ->and($raw)->not->toBe('Clinic')
        ->and(Crypt::decrypt($raw))->toBe('Clinic');
});

it('decrypts resource values', function () {
    $cast = new EncryptedBinary();
    $encrypted = Crypt::encrypt('test');
    $stream = fopen('php://temp', 'r+');
    fwrite($stream, $encrypted);
    rewind($stream);

    $value = $cast->get(new Person(), 'first_name', $stream, []);

    expect($value)->toBe('test');
});
