<?php

namespace App\Enums;

enum OrganizationType: string
{
    case NATURAL_PERSON = 'natural_person';
    case LEGAL_ENTITY = 'legal_entity';

    public function label(): string
    {
        return match ($this) {
            self::NATURAL_PERSON => __('doceus.organization.natural_person'),
            self::LEGAL_ENTITY => __('doceus.organization.legal_entity'),
        };
    }
}
