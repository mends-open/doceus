<?php

namespace App\Feature\MorphClass\Enums;

enum MorphClass: string
{
    case ContactPoint = 'contact_point';
    case OrganizationPatient = 'organization_patient';
    case Patient = 'patient';
    case PatientPractitioner = 'patient_practitioner';
    case Practitioner = 'practitioner';
    case PractitionerQualification = 'practitioner_qualification';
    case User = 'user';
    case Organization = 'organization';
    case OrganizationPractitioner = 'organization_practitioner';
    case Person = 'person';
}
