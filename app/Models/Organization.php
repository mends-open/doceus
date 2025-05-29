<?php

namespace App\Models;

use App\Enums\OrganizationType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'type' => OrganizationType::class,
    ];

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organization_user');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'organization_role');
    }
}
