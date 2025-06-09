<?php

namespace App\Feature\Identity\Enums;

enum PrectitionerQualification: string
{
    case MedicalStudent = 'medical_student';
    case MedicalIntern = 'medical_intern';
    case MedicalDoctor = 'medical_doctor';
    case MedicalResident = 'medical_resident';
    case MedicalAssistant = 'medical_assistant';
    case DentistryStudent = 'dentistry_student';
    case DentistryIntern = 'dentistry_intern';
    case DentistryDoctor = 'dentistry_doctor';
    case DentistryResident = 'dentistry_resident';
    case DentistryAssistant = 'dentistry_assistant';
}
