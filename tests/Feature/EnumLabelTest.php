<?php

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\Language;
use App\Feature\Identity\Enums\OrganizationType;
use App\Feature\Revision\Enums\RevisionType;

it('translates gender labels', function () {
    app()->setLocale('en');
    foreach (Gender::cases() as $gender) {
        expect($gender->label())->not->toBe('doceus.gender.'.$gender->value);
    }
});

it('translates organization type labels', function () {
    app()->setLocale('en');
    foreach (OrganizationType::cases() as $type) {
        expect($type->label())->not->toBe('doceus.organization_type.'.$type->value);
    }
});

it('translates revision type labels', function () {
    app()->setLocale('en');
    foreach (RevisionType::cases() as $type) {
        expect($type->label())->not->toBe('doceus.revision_type.'.$type->value);
    }
});

it('translates language labels', function () {
    app()->setLocale('en');
    foreach (Language::cases() as $lang) {
        expect($lang->label())->not->toBe('doceus.language.'.$lang->value);
    }
});
