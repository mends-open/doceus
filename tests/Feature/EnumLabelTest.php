<?php

namespace Tests\Feature;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\OrganizationType;
use App\Feature\Revision\Enums\RevisionType;
use App\Feature\Identity\Enums\Language;
use Tests\TestCase;

class EnumLabelTest extends TestCase
{
    public function test_gender_labels_are_translated(): void
    {
        app()->setLocale('en');
        foreach (Gender::cases() as $gender) {
            $this->assertNotSame('doceus.gender.' . $gender->value, $gender->label());
        }
    }

    public function test_organization_type_labels_are_translated(): void
    {
        app()->setLocale('en');
        foreach (OrganizationType::cases() as $type) {
            $this->assertNotSame('doceus.organization_type.' . $type->value, $type->label());
        }
    }

    public function test_revision_type_labels_are_translated(): void
    {
        app()->setLocale('en');
        foreach (RevisionType::cases() as $type) {
            $this->assertNotSame('doceus.revision_type.' . $type->value, $type->label());
        }
    }

    public function test_language_labels_are_translated(): void
    {
        app()->setLocale('en');
        foreach (Language::cases() as $lang) {
            $this->assertNotSame('doceus.language.' . $lang->value, $lang->label());
        }
    }
}
