<?php

namespace Tests\Feature;

use App\Feature\Sqid\Sqid;
use App\Models\Organization;
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
}
