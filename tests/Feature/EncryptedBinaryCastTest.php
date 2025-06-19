<?php

use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('stores encrypted data as binary and decrypts on retrieval', function () {
    $org = Organization::factory()->create(['name' => 'Secret']);

    $raw = DB::table('organizations')->where('id', $org->id)->value('name');

    expect($raw)->not->toBe('Secret');
    expect(Crypt::decryptString(base64_encode($raw)))->toBe('Secret');

    $org->refresh();
    expect($org->name)->toBe('Secret');
});
