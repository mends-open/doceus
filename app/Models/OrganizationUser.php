<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrganizationUser extends Pivot
{
    protected $table = 'organization_users';

    protected $guarded = [];

    public $incrementing = false;

    public $timestamps = false;

// Classic pivot, if you want it
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(
            Organization::class,
            'organization_users'
        )->using(OrganizationUser::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
