<?php

use App\Models\Person;

it('returns true when required fields present', function () {
    $person = Person::factory()->make([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'pesel' => '44051401359',
    ]);

    expect($person->isComplete())->toBeTrue();
});

it('returns false when any field missing', function () {
    $person = Person::make();

    expect($person->isComplete())->toBeFalse();
});
