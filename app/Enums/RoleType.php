<?php

namespace App\Enums;

use App\Enums\Traits\HasTranslatableLabel;

enum RoleType: string
{

    use HasTranslatableLabel;
    // Physicians
    case IS_MEDICAL_DOCTOR = 'is_medical_doctor';
    case IS_DENTISTRY_DOCTOR = 'is_dentistry_doctor';
    case IS_INTERN_DOCTOR = 'is_intern_doctor';
    case IS_RESIDENT_DOCTOR = 'is_resident_doctor';

    // Students
    case IS_MEDICAL_STUDENT = 'is_medical_student';
    case IS_DENTISTRY_STUDENT = 'is_dentistry_student';
    case IS_PSYCHOLOGY_STUDENT = 'is_psychology_student';

    // Mental Health Professionals
    case IS_PSYCHOLOGIST = 'is_psychologist';
    case IS_PSYCHOTHERAPIST = 'is_psychotherapist';

    // Administrative and Support Roles
    case IS_MEDICAL_ASSISTANT = 'is_medical_assistant';
    case IS_HEALTHCARE_MANAGER = 'is_healthcare_manager';

    case HAS_REGISTERED_PRACTICE = 'has_registered_practice';

    protected function translationPrefix(): string
    {
        return 'doceus.role';
    }
}
