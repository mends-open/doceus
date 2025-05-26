<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserGenerateNameTest extends TestCase
{
    public function test_generates_name_from_first_and_last_name(): void
    {
        $user = User::make([
            'first_name' => 'john',
            'last_name' => 'doe',
        ]);

        $this->assertSame('John Doe', $user->name);
    }

    public function test_generates_name_from_first_name_only(): void
    {
        $user = User::make([
            'first_name' => 'jane',
        ]);

        $this->assertSame('Jane', $user->name);
    }

    public function test_generates_name_from_last_name_only(): void
    {
        $user = User::make([
            'last_name' => 'smith',
        ]);

        $this->assertSame('Smith', $user->name);
    }

    public function test_generates_name_from_email_when_no_name_fields(): void
    {
        $user = User::make([
            'email' => 'john.smith@example.com',
        ]);

        $this->assertSame('John Smith', $user->name);
    }

    public function test_generates_default_name_when_no_fields_present(): void
    {
        $user = new User;

        $this->assertSame('User', $user->name);
    }
}
