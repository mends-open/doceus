<?php

namespace App\Traits;

trait BelongsToManyOrganizations
{
    public static function getTenantOwnershipRelationshipName(): string
    {
        return 'organizations';
    }
}
