<?php

namespace App\Models;

use App\Enums\OrganizationType;
use App\Models\OrganizationFeature;
use App\Models\OrganizationUser;
use App\Models\OrganizationUserFeature;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $casts = [
        'type' => OrganizationType::class,
    ];

    public function getNameAttribute(): string
    {
        return $this->type?->label() ?? '';
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class)->using(OrganizationUser::class);
    }

    public function uniqueUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(OrganizationUser::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(OrganizationFeature::class);
    }

}
