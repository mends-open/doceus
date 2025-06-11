<?php

namespace App\Feature\Polymorphic\Enums;

enum MorphType: string
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
