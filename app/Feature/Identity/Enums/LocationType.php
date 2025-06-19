<?php

namespace App\Feature\Identity\Enums;

enum LocationType: string
{
    case Virtual = 'virtual';
    case Office = 'office';
    case HomeVisit = 'home_visit';
    case Other = 'other';
}
