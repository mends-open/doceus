<?php

namespace App\Feature\Polymorphic\Enums;

enum MorphType: string
{
    case OrganizationPatient = 'organization_patient';
    case Patient = 'patient';
    case PatientPractitioner = 'patient_practitioner';
    case Practitioner = 'practitioner';
    case User = 'user';
    case Organization = 'organization';
    case OrganizationPractitioner = 'organization_practitioner';
    case Location = 'location';
    case Person = 'person';
}
