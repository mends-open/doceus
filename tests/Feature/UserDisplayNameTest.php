<?php

use App\Models\Person;
use App\Models\User;

it('generates name from first and last name', function () {
    $user = new User;
    $user->setRelation('person', Person::make([
        'first_name' => 'john',
        'last_name' => 'doe',
    ]));

    expect($user->name)->toBe('John Doe');
});

it('generates name from first name only', function () {
    $user = new User;
    $user->setRelation('person', Person::make([
        'first_name' => 'jane',
    ]));

    expect($user->name)->toBe('Jane');
});

it('generates name from last name only', function () {
    $user = new User;
    $user->setRelation('person', Person::make([
        'last_name' => 'smith',
    ]));

    expect($user->name)->toBe('Smith');
});

it('generates name from email when no name fields', function () {
    $user = User::make([
        'email' => 'john.smith@example.com',
    ]);

    expect($user->name)->toBe('John Smith');
});

it('generates default name when no fields present', function () {
    $user = new User;

    expect($user->name)->toBe('User');
});
