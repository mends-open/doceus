<?php

use App\Feature\Sqid\Sqid;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('encodes and decodes values', function () {
    config()->set('sqid.alphabet', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    config()->set('sqid.length', 5);

    $encoded = Sqid::encode(42);
    expect($encoded)->toBeString()
        ->and(Sqid::decode($encoded))->toBe(42);
});

it('generates sqid and resolves route binding', function () {
    config()->set('sqid.alphabets.organization', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    config()->set('sqid.length', 5);

    $organization = Organization::factory()->create();

    expect($organization->sqid)->toBeString()
        ->and(Sqid::decode($organization->sqid))->toBe($organization->id)
        ->and($organization->getRouteKey())->toBe($organization->sqid);

    $resolved = $organization->resolveRouteBinding($organization->sqid);
    expect($organization->is($resolved))->toBeTrue();
});

it('decodes sqid when resolving route binding query', function () {
    config()->set('sqid.alphabets.organization', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    config()->set('sqid.length', 5);

    $organization = Organization::factory()->create();

    $query = Organization::query();
    $resolved = (new Organization)->resolveRouteBindingQuery($query, $organization->sqid)->first();

    expect($organization->is($resolved))->toBeTrue();
});

it('decodes sqid with relation constraints', function () {
    config()->set('sqid.alphabets.person', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    config()->set('sqid.length', 5);

    $organization = Organization::factory()->create();
    $patient = Patient::factory()->create();
    $patient->organizations()->attach($organization);

    $person = $patient->person;

    $query = Person::query()->whereExists(function ($q) use ($organization) {
        $q->from('organizations')
            ->join('organization_patient', 'organization_patient.organization_id', '=', 'organizations.id')
            ->whereColumn('people.id', 'organization_patient.patient_id')
            ->where('organizations.id', $organization->id)
            ->whereNull('organizations.deleted_at');
    });

    $resolved = (new Person)->resolveRouteBindingQuery($query, $person->sqid)->first();

    expect($person->is($resolved))->toBeTrue();
});
