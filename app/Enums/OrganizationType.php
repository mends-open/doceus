<?php

namespace App\Enums;

enum OrganizationType: string
{
    case NATURAL_PERSON = 'natural_person';
    case LEGAL_ENTITY = 'legal_entity';

    public function label(): string
    {
        return match ($this) {
            self::NATURAL_PERSON => 'Natural Person',
            self::LEGAL_ENTITY => 'Legal Entity',
        };
    }
}
