<?php

namespace App\Models;

use App\Enums\FeatureEvent;
use App\Enums\OrganizationFeature as OrganizationFeatureEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property OrganizationFeatureEnum $feature
 * @property FeatureEvent $event
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\Organization|null $organization
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent query()
 *
 * @mixin \Eloquent
 */
class OrganizationFeatureEvent extends Model
{
    use HasFactory, HasUuids;

    protected $casts = [
        'feature' => OrganizationFeatureEnum::class,
        'event' => FeatureEvent::class,
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
