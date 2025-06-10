<?php

namespace Tests\Feature;

use App\Feature\Sqid\Sqid;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SqidTest extends TestCase
{
    use RefreshDatabase;

    public function test_encode_and_decode(): void
    {
        config()->set('sqid.alphabet', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        config()->set('sqid.length', 5);

        $encoded = Sqid::encode(42);
        $this->assertIsString($encoded);
        $this->assertSame(42, Sqid::decode($encoded));
    }

    public function test_trait_generates_sqid_and_route_binding(): void
    {
        config()->set('sqid.alphabets.organization', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        config()->set('sqid.length', 5);

        $organization = Organization::factory()->create();

        $this->assertIsString($organization->sqid);
        $this->assertSame($organization->id, Sqid::decode($organization->sqid));
        $this->assertSame($organization->sqid, $organization->getRouteKey());

        $resolved = $organization->resolveRouteBinding($organization->sqid);
        $this->assertTrue($organization->is($resolved));
    }

    public function test_resolve_route_binding_query_decodes_sqid(): void
    {
        config()->set('sqid.alphabets.organization', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        config()->set('sqid.length', 5);

        $organization = Organization::factory()->create();

        $query = Organization::query();
        $resolved = (new Organization())->resolveRouteBindingQuery($query, $organization->sqid)->first();

        $this->assertTrue($organization->is($resolved));
    }

    public function test_resolve_route_binding_query_with_relation_constraints(): void
    {
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

        $resolved = (new Person())->resolveRouteBindingQuery($query, $person->sqid)->first();

        $this->assertTrue($person->is($resolved));
    }
}
