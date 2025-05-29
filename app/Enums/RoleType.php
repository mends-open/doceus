<?php

namespace App\Enums;

use App\Enums\Traits\HasTranslatableLabel;

enum RoleType: string
{

    use HasTranslatableLabel;
    // Physicians
    case MEDICAL_DOCTOR = 'medical_doctor';
    case DENTAL_DOCTOR = 'dental_doctor';
    case INTERN_DOCTOR = 'intern_doctor';
    case RESIDENT_DOCTOR = 'resident_doctor';

    // Students
    case MEDICAL_STUDENT = 'medical_student';
    case DENTISTRY_STUDENT = 'dentistry_student';
    case PSYCHOLOGY_STUDENT = 'psychology_student';

    // Mental Health Professionals
    case PSYCHOLOGIST = 'psychologist';
    case PSYCHOTHERAPIST = 'psychotherapist';

    // Administrative and Support Roles
    case MEDICAL_ASSISTANT = 'medical_assistant';
    case HEALTHCARE_MANAGER = 'healthcare_manager';

    case HAS_REGISTERED_PRACTICE = 'has_registered_practice';

    protected function translationPrefix(): string
    {
        return 'doceus.role';
    }
}
