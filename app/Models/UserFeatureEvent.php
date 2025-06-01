<?php

namespace App\Models;

use App\Enums\FeatureEvent;
use App\Enums\UserFeature;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $organization_id
 * @property string $user_id
 * @property UserFeature $feature
 * @property FeatureEvent $event
 * @property string $created_at
 * @property string $created_by
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\OrganizationUser|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Organization> $organizations
 * @property-read int|null $organizations_count
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeatureEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeatureEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeatureEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeatureEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeatureEvent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeatureEvent whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeatureEvent whereFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeatureEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeatureEvent whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeatureEvent whereUserId($value)
 *
 * @mixin \Eloquent
 */
class UserFeatureEvent extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'organization_id',
        'user_id',
        'feature',
        'event',
        'created_by',
    ];

    protected $casts = [
        'feature' => UserFeature::class,
        'event' => FeatureEvent::class,
    ];

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)
            ->using(OrganizationUser::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
