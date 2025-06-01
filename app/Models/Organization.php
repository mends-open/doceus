<?php

namespace App\Models;

use App\Enums\OrganizationType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property OrganizationType $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrganizationFeatureEvent> $features
 * @property-read int|null $features_count
 * @property-read string $name
 * @property-read \App\Models\OrganizationUser|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $uniqueUsers
 * @property-read int|null $unique_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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
        return $this->hasMany(OrganizationFeatureEvent::class);
    }
}
