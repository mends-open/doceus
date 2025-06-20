<?php

use App\Feature\Polymorphic\Enums\MorphType;
use App\Feature\Revision\Enums\RevisionType;
use App\Feature\Revision\Models\Revision;
use App\Models\Organization;
use App\Models\OrganizationPractitioner;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('records revisions for user CRUD', function () {
    $initial = Revision::count();
    $user = User::factory()->create();
    expect(Revision::count())->toBe($initial + 2);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::User->value,
        'revisionable_id' => $user->id,
        'type' => RevisionType::Created->value,
    ]);

    $user->update(['email' => 'updated@example.com']);
    expect(Revision::count())->toBe($initial + 3);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::User->value,
        'revisionable_id' => $user->id,
        'type' => RevisionType::Updated->value,
    ]);

    $user->delete();
    expect(Revision::count())->toBe($initial + 4);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::User->value,
        'revisionable_id' => $user->id,
        'type' => RevisionType::Deleted->value,
    ]);

    $user->restore();
    expect(Revision::count())->toBe($initial + 5);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::User->value,
        'revisionable_id' => $user->id,
        'type' => RevisionType::Restored->value,
    ]);

    $user->forceDelete();
    expect(Revision::count())->toBe($initial + 6);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::User->value,
        'revisionable_id' => $user->id,
        'type' => RevisionType::ForceDeleted->value,
    ]);
});

it('records revisions for organization CRUD', function () {
    $initial = Revision::count();
    $org = Organization::factory()->create();
    expect(Revision::count())->toBe($initial + 1);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::Organization->value,
        'revisionable_id' => $org->id,
        'type' => RevisionType::Created->value,
    ]);

    $org->update(['name' => 'Updated']);
    expect(Revision::count())->toBe($initial + 2);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::Organization->value,
        'revisionable_id' => $org->id,
        'type' => RevisionType::Updated->value,
    ]);

    $org->delete();
    expect(Revision::count())->toBe($initial + 3);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::Organization->value,
        'revisionable_id' => $org->id,
        'type' => RevisionType::Deleted->value,
    ]);

    $org->restore();
    expect(Revision::count())->toBe($initial + 4);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::Organization->value,
        'revisionable_id' => $org->id,
        'type' => RevisionType::Restored->value,
    ]);

    $org->forceDelete();
    expect(Revision::count())->toBe($initial + 5);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::Organization->value,
        'revisionable_id' => $org->id,
        'type' => RevisionType::ForceDeleted->value,
    ]);
});

it('records revisions for person CRUD', function () {
    $initial = Revision::count();
    $person = Person::factory()->create();
    expect(Revision::count())->toBe($initial + 1);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::Person->value,
        'revisionable_id' => $person->id,
        'type' => RevisionType::Created->value,
    ]);

    $person->update(['first_name' => 'Updated']);
    expect(Revision::count())->toBe($initial + 2);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::Person->value,
        'revisionable_id' => $person->id,
        'type' => RevisionType::Updated->value,
    ]);

    $person->delete();
    expect(Revision::count())->toBe($initial + 3);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::Person->value,
        'revisionable_id' => $person->id,
        'type' => RevisionType::Deleted->value,
    ]);

    $person->restore();
    expect(Revision::count())->toBe($initial + 4);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::Person->value,
        'revisionable_id' => $person->id,
        'type' => RevisionType::Restored->value,
    ]);

    $person->forceDelete();
    expect(Revision::count())->toBe($initial + 5);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::Person->value,
        'revisionable_id' => $person->id,
        'type' => RevisionType::ForceDeleted->value,
    ]);
});

it('records revisions for user organization relationships', function () {
    $user = User::factory()->create();
    $org = Organization::factory()->create();

    \App\Models\Practitioner::factory()->for($user->person)->create();

    $initial = Revision::count();

    $user->organizations()->attach($org->id);
    $pivot = OrganizationPractitioner::where('practitioner_id', $user->practitioner->id)
        ->where('organization_id', $org->id)
        ->first();
    expect($pivot)->not->toBeNull();
    expect(Revision::count())->toBeGreaterThan($initial);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::OrganizationPractitioner->value,
        'revisionable_id' => $pivot->id,
        'type' => RevisionType::Created->value,
    ]);

    $org->practitioners()->detach($user->practitioner->id);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::OrganizationPractitioner->value,
        'revisionable_id' => $pivot->id,
        'type' => RevisionType::Deleted->value,
    ]);

    $org2 = Organization::factory()->create();
    $user->organizations()->sync([$org2->id]);
    $pivot2 = OrganizationPractitioner::where('practitioner_id', $user->practitioner->id)
        ->where('organization_id', $org2->id)
        ->first();
    expect($pivot2)->not->toBeNull();
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::OrganizationPractitioner->value,
        'revisionable_id' => $pivot2->id,
        'type' => RevisionType::Created->value,
    ]);
});

it('records revisions for patient practitioner relationships', function () {
    $patient = \App\Models\Patient::factory()->create();
    $practitioner = \App\Models\Practitioner::factory()->create();

    $initial = Revision::count();

    $practitioner->patients()->attach($patient->id);
    $pivot = \App\Models\PatientPractitioner::where('patient_id', $patient->id)
        ->where('practitioner_id', $practitioner->id)
        ->first();
    expect($pivot)->not->toBeNull();
    expect(Revision::count())->toBeGreaterThan($initial);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::PatientPractitioner->value,
        'revisionable_id' => $pivot->id,
        'type' => RevisionType::Created->value,
    ]);

    $practitioner->patients()->detach($patient->id);
    $this->assertDatabaseHas('revisions', [
        'revisionable_type' => MorphType::PatientPractitioner->value,
        'revisionable_id' => $pivot->id,
        'type' => RevisionType::Deleted->value,
    ]);
});
