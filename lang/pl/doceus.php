<?php

return [
    'user' => [
        'first_name' => 'Imię',
        'last_name' => 'Nazwisko',
        'email' => 'Email',
        'language' => 'Język',
    ],
    'auth' => [
        'first_name' => 'Imię',
        'last_name' => 'Nazwisko',
        'pesel' => 'PESEL',
    ],
    'organization' => [
        'label' => 'Organizacja',
        'plural_label' => 'Organizacje',
    ],
    'organization_type' => [
        'label' => 'Typ organizacji',
        'individual' => 'Osoba indywidualna',
        'entity' => 'Jednostka',
    ],
    'user_feature' => [
        'is_medical_doctor' => 'Lekarz',
        'is_medical_assistant' => 'Asystent medyczny',
        'is_dentistry_doctor' => 'Dentysta',
        'is_intern_doctor' => 'Lekarz stażysta',
        'is_resident_doctor' => 'Lekarz rezydent',
        'is_medical_student' => 'Student medycyny',
        'is_dentistry_student' => 'Student stomatologii',
        'is_psychology_student' => 'Student psychologii',
        'is_psychologist' => 'Psycholog',
        'is_psychotherapist' => 'Psychoterapeuta',
        'has_registered_practice' => 'Posiada zarejestrowaną praktykę',
        'is_healthcare_manager' => 'Menedżer ochrony zdrowia',
        'is_superadmin' => 'Superadministrator',
        'is_admin' => 'Administrator',
        'is_owner' => 'Właściciel',
        'is_user' => 'Użytkownik',
    ],
    'organization_feature' => [
        'is_registered_practice' => 'Zarejestrowana praktyka',
        'is_specialized_practice' => 'Specjalistyczna praktyka medyczna',
        'is_medical_practice' => 'Praktyka lekarska',
        'is_dental_practice' => 'Praktyka dentystyczna',
        'is_group_medical_practice' => 'Grupowa praktyka lekarska',
        'is_medical_facility' => 'Placówka medyczna',
    ],
    'feature_event' => [
        'granted' => 'Przyznano',
        'revoked' => 'Cofnięto',
    ],
    'language' => [
        'en' => 'Angielski',
        'pl' => 'Polski',
    ],
    'pesel' => [
        'exact-eleven-digits' => 'PESEL musi składać się dokładnie z 11 cyfr.',
        'invalid' => 'Niepoprawny numer PESEL.',
    ],
    'gender' => [
        'label' => 'Płeć',
        'male' => 'Mężczyzna',
        'female' => 'Kobieta',
        'other' => 'Inna',
    ],
    'birth_date' => 'Data urodzenia',
    'id_number' => 'Numer dokumentu',
    'settings' => 'Ustawienia',
];
