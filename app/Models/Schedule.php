<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property array $entries
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Location> $locations
 * @property-read int|null $locations_count
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
        'entries',
    ];

    protected array $revisionable = [
        'entries',
    ];

    protected $casts = [
        'entries' => 'array',
    ];

    public function practitioners(): BelongsToMany
    {
        return $this->belongsToMany(Practitioner::class)
            ->using(PractitionerSchedule::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class)
            ->using(LocationSchedule::class);
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
