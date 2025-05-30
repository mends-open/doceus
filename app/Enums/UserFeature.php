<?php

namespace App\Enums;

use App\Enums\Traits\HasTranslatableLabel;

enum UserFeature: string
{
    use HasTranslatableLabel;

    // Physicians
    case IS_MEDICAL_DOCTOR      = 'is_medical_doctor';
    case IS_DENTISTRY_DOCTOR    = 'is_dentistry_doctor';
    case IS_RESIDENT_DOCTOR     = 'is_resident_doctor';
    case IS_INTERN_DOCTOR       = 'is_intern_doctor';

    // Students
    case IS_MEDICAL_STUDENT     = 'is_medical_student';
    case IS_DENTISTRY_STUDENT   = 'is_dentistry_student';
    case IS_PSYCHOLOGY_STUDENT  = 'is_psychology_student';

    // Mental Health Professionals
    case IS_PSYCHOLOGIST        = 'is_psychologist';
    case IS_PSYCHOTHERAPIST     = 'is_psychotherapist';

    // Administrative and Support Roles
    case IS_MEDICAL_ASSISTANT   = 'is_medical_assistant';
    case IS_SUPERADMIN          = 'is_superadmin';      // App-wide system admin
    case IS_ADMIN               = 'is_admin';           // Organization admin
    case IS_OWNER               = 'is_owner';           // Legal/founder owner of organization
    case IS_USER                = 'is_user';            // Regular member/user

    protected function translationPrefix(): string
    {
        return 'doceus.feature';
    }
}
