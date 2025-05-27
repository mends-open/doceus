<?php

namespace App\Enums;

enum PersonnelType: string
{
    case MEDICAL_DOCTOR = 'medical_doctor';
    case DENTISTRY_DOCTOR = 'dentistry_doctor';
    case MEDICAL_ASSISTANT = 'medical_assistant';
}
