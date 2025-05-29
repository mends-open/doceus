<?php

namespace App\Enums;

enum RoleType: string
{
    case IS_MEDICAL_DOCTOR = 'is_medical_doctor';

    case IS_MEDICAL_ASSISTANT = 'is_medical_assistant';

    case IS_DENTISTRY_DOCTOR = 'is_dentistry_doctor';

    case IS_MEDICAL_STUDENT = 'is_medical_student';

    case IS_DENTISTRY_STUDENT = 'is_dentistry_student';

    case IS_PSYCHOLOGY_STUDENT = 'is_psychology_student';

    case IS_PSYCHOLOGIST = 'is_psychologist';

    case IS_PSYCHOTHERAPIST = 'is_psychotherapist';

    case HAS_REGISTERED_PRACTICE = 'has_registered_practice';

    public function label(): string
    {
        return __("doceus.role.{$this->value}");
    }
}
