<?php

namespace Tests\Feature;

use App\Feature\MorphClass\Enums\MorphClass;
use App\Feature\Revision\Enums\RevisionType;
use App\Feature\Revision\Models\Revision;
use App\Models\Organization;
use App\Models\OrganizationPractitioner;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevisionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_revisions_for_crud(): void
    {
        $initial = Revision::count();
        $user = User::factory()->create();
        $this->assertSame($initial + 1, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::User->value,
            'revisionable_id' => $user->id,
            'type' => RevisionType::Created->value,
        ]);

        $user->update(['email' => 'updated@example.com']);
        $this->assertSame($initial + 2, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::User->value,
            'revisionable_id' => $user->id,
            'type' => RevisionType::Updated->value,
        ]);

        $user->delete();
        $this->assertSame($initial + 3, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::User->value,
            'revisionable_id' => $user->id,
            'type' => RevisionType::Deleted->value,
        ]);

        $user->restore();
        $this->assertSame($initial + 4, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::User->value,
            'revisionable_id' => $user->id,
            'type' => RevisionType::Restored->value,
        ]);

        $user->forceDelete();
        $this->assertSame($initial + 5, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::User->value,
            'revisionable_id' => $user->id,
            'type' => RevisionType::ForceDeleted->value,
        ]);
    }

    public function test_organization_revisions_for_crud(): void
    {
        $initial = Revision::count();
        $org = Organization::factory()->create();
        $this->assertSame($initial + 1, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Organization->value,
            'revisionable_id' => $org->id,
            'type' => RevisionType::Created->value,
        ]);

        $org->update(['name' => 'Updated']);
        $this->assertSame($initial + 2, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Organization->value,
            'revisionable_id' => $org->id,
            'type' => RevisionType::Updated->value,
        ]);

        $org->delete();
        $this->assertSame($initial + 3, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Organization->value,
            'revisionable_id' => $org->id,
            'type' => RevisionType::Deleted->value,
        ]);

        $org->restore();
        $this->assertSame($initial + 4, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Organization->value,
            'revisionable_id' => $org->id,
            'type' => RevisionType::Restored->value,
        ]);

        $org->forceDelete();
        $this->assertSame($initial + 5, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Organization->value,
            'revisionable_id' => $org->id,
            'type' => RevisionType::ForceDeleted->value,
        ]);
    }

    public function test_person_revisions_for_crud(): void
    {
        $initial = Revision::count();
        $person = Person::factory()->create();
        $this->assertSame($initial + 1, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Person->value,
            'revisionable_id' => $person->id,
            'type' => RevisionType::Created->value,
        ]);

        $person->update(['first_name' => 'Updated']);
        $this->assertSame($initial + 2, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Person->value,
            'revisionable_id' => $person->id,
            'type' => RevisionType::Updated->value,
        ]);

        $person->delete();
        $this->assertSame($initial + 3, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Person->value,
            'revisionable_id' => $person->id,
            'type' => RevisionType::Deleted->value,
        ]);

        $person->restore();
        $this->assertSame($initial + 4, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Person->value,
            'revisionable_id' => $person->id,
            'type' => RevisionType::Restored->value,
        ]);

        $person->forceDelete();
        $this->assertSame($initial + 5, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Person->value,
            'revisionable_id' => $person->id,
            'type' => RevisionType::ForceDeleted->value,
        ]);
    }

    public function test_user_organization_relationship_revisions(): void
    {
        $user = User::factory()->create();
        $org = Organization::factory()->create();

        $initial = Revision::count();

        // Attach from user side
        $user->organizations()->attach($org->id);
        $pivot = OrganizationPractitioner::where('practitioner_id', $user->practitioner->id)
            ->where('organization_id', $org->id)
            ->first();
        $this->assertNotNull($pivot);
        $this->assertGreaterThan($initial, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::OrganizationPractitioner->value,
            'revisionable_id' => $pivot->id,
            'type' => RevisionType::Created->value,
        ]);

        // Detach from organization side
        $org->users()->detach($user->id);
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::OrganizationPractitioner->value,
            'revisionable_id' => $pivot->id,
            'type' => RevisionType::Deleted->value,
        ]);

        // Sync from user side with new organization
        $org2 = Organization::factory()->create();
        $user->organizations()->sync([$org2->id]);
        $pivot2 = OrganizationPractitioner::where('practitioner_id', $user->practitioner->id)
            ->where('organization_id', $org2->id)
            ->first();
        $this->assertNotNull($pivot2);
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::OrganizationPractitioner->value,
            'revisionable_id' => $pivot2->id,
            'type' => RevisionType::Created->value,
        ]);
    }
}
