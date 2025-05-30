<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\BlindIndex;
use Tests\TestCase;

class BlindIndexFacadeTest extends TestCase
{
    public function test_can_update_model_using_facade(): void
    {
        $user = new User();
        $user->email = 'test@example.com';

        BlindIndex::for($user)->update();

        $expected = BlindIndex::hash('test@example.com');
        $this->assertSame($expected, $user->email_blind_index);
    }
}
