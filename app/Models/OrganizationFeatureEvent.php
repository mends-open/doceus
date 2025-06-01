<?php

namespace App\Models;

use App\Enums\FeatureEvent;
use App\Enums\OrganizationFeature as OrganizationFeatureEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property string $id
 * @property string $organization_id
 * @property OrganizationFeatureEnum $feature
 * @property FeatureEvent $event
 * @property \Illuminate\Support\Carbon $created_at
 * @property string $created_by
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\Organization $organization
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent whereFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeatureEvent whereOrganizationId($value)
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
