<?php

use App\Feature\Identity\Rules\ValidPesel;
use Illuminate\Support\Facades\Validator;

it('passes with valid pesel', function () {
    $data = ['pesel' => '44051401359'];
    $rule = ['pesel' => [new ValidPesel()]];

    $validator = Validator::make($data, $rule);
    expect($validator->passes())->toBeTrue();
});

it('fails with invalid checksum', function () {
    $data = ['pesel' => '44051401358'];
    $rule = ['pesel' => [new ValidPesel()]];

    $validator = Validator::make($data, $rule);
    expect($validator->passes())->toBeFalse();
});

it('fails with incorrect length', function () {
    $data = ['pesel' => '1234567890'];
    $rule = ['pesel' => [new ValidPesel()]];

    $validator = Validator::make($data, $rule);
    expect($validator->passes())->toBeFalse();
});
