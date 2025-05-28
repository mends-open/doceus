<?php

namespace App\Enums;

enum PersonnelType: string
{
    case MEDICAL_DOCTOR = 'medical_doctor';
    case DENTISTRY_DOCTOR = 'dentistry_doctor';
    case MEDICAL_ASSISTANT = 'medical_assistant';

    public function label(): string
    {
        return match ($this) {
            self::MEDICAL_DOCTOR => __('doceus.personnel.medical_doctor'),
            self::DENTISTRY_DOCTOR => __('doceus.personnel.dentistry_doctor'),
            self::MEDICAL_ASSISTANT => __('doceus.personnel.medical_assistant'),
        };
    }
}
