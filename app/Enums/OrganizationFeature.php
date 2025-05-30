<?php

namespace App\Enums;

use App\Enums\Traits\HasTranslatableLabel;

enum OrganizationFeature: string
{

    use HasTranslatableLabel;
    case IS_REGISTERED_PRACTICE = 'is_registered_practice';
    case IS_SPECIALIZED_MEDICAL_PRACTICE = 'is_specialized_practice';
    case IS_MEDICAL_PRACTICE = 'is_medical_practice';
    case IS_DENTAL_PRACTICE = 'is_dental_practice';
    case IS_GROUP_MEDICAL_PRACTICE = 'is_group_medical_practice';
    case IS_MEDICAL_FACILITY = 'is_medical_facility';
    // Add more as needed
    protected function translationPrefix(): string
    {
        return 'doceus.organization_feature';
    }

}
