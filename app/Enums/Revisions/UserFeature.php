<?php

namespace App\Enums\Revisions;

use App\Traits\HasTranslatableLabel;

enum UserFeature: string
{
    use HasTranslatableLabel;

    // Physicians
    case MEDICAL_DOCTOR = 'is_medical_doctor';
    case DENTISTRY_DOCTOR = 'is_dentistry_doctor';
    case RESIDENT_DOCTOR = 'is_resident_doctor';
    case INTERN_DOCTOR = 'is_intern_doctor';

    // Students
    case MEDICAL_STUDENT = 'is_medical_student';
    case DENTISTRY_STUDENT = 'is_dentistry_student';
    case PSYCHOLOGY_STUDENT = 'is_psychology_student';

    // Mental Health Professionals
    case PSYCHOLOGIST = 'is_psychologist';
    case PSYCHOTHERAPIST = 'is_psychotherapist';

    // Administrative and Support Roles
    case MEDICAL_ASSISTANT = 'is_medical_assistant';
    case SUPERADMIN = 'is_superadmin';      // App-wide system admin
    case ADMIN = 'is_admin';           // Organization admin
    case OWNER = 'is_owner';           // Legal/founder owner of organization
    case USER = 'is_user';            // Regular member/user

    protected function translationPrefix(): string
    {
        return 'doceus.user_feature';
    }
}
