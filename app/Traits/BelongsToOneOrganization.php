<?php

namespace App\Traits;

trait BelongsToOneOrganization
{
    public static function getTenantOwnershipRelationshipName(): string
    {
        return 'organization';
    }

}
