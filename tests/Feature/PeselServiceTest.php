<?php

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Services\Pesel;
use Carbon\Carbon;

it('extracts birth date from valid pesel', function () {
    $birthDate = Pesel::extractBirthDate('44051401359');
    expect($birthDate)->toBeInstanceOf(Carbon::class)
        ->and($birthDate->format('Y-m-d'))->toBe('1944-05-14');
});

it('returns null for invalid pesel when extracting birth date', function () {
    expect(Pesel::extractBirthDate('1234567890'))->toBeNull();
});

it('extracts gender from valid pesel', function () {
    expect(Pesel::extractGender('44051401359'))->toBe(Gender::Male);
});

it('returns null for invalid pesel when extracting gender', function () {
    expect(Pesel::extractGender('invalid'))->toBeNull();
});
