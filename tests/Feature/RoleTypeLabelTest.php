<?php

namespace Tests\Feature;

use App\Enums\RoleType;
use Tests\TestCase;

class RoleTypeLabelTest extends TestCase
{
    public function test_label_returns_translated_value(): void
    {
        app()->setLocale('en');

        $this->assertSame('Super administrator', RoleType::IS_SUPERADMIN->label());
        $this->assertSame('Administrator', RoleType::IS_ADMIN->label());
    }
}
