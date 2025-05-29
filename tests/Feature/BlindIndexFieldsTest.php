<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class BlindIndexFieldsTest extends TestCase
{
    public function test_returns_configured_fields(): void
    {
        $user = new User();

        $expected = ['email', 'first_name', 'last_name', 'pesel'];

        $this->assertSame($expected, $user->getBlindIndexFields());
    }
}
