<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $schedulable_type
 * @property int $schedulable_id
 * @property int $location_id
 * @property array $entries
 * @property-read Model|null $schedulable
 * @property-read Location $location
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Organization> $organizations
 * @property-read int|null $organizations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Practitioner> $practitioners
 * @property-read int|null $practitioners_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Slot> $slots
 * @property-read int|null $slots_count
 */
class Schedule extends BaseModel
{
    protected $fillable = [
        'schedulable_type',
        'schedulable_id',
        'location_id',
        'entries',
    ];

    protected array $revisionable = [
        'schedulable_type',
        'schedulable_id',
        'location_id',
        'entries',
    ];

    protected $casts = [
        'entries' => 'array',
    ];

    public function schedulable(): MorphTo
    {
        return $this->morphTo();
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function practitioners(): BelongsToMany
    {
        return $this->belongsToMany(Practitioner::class)
            ->using(PractitionerSchedule::class);
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)
            ->using(OrganizationSchedule::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
