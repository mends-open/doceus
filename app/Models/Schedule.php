<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $location_id
 * @property array $entries
 * @property-read Practitioner|null $practitioner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Slot> $slots
 * @property-read int|null $slots_count
 */
class Schedule extends BaseModel
{
    protected $fillable = [
        'location_id',
        'entries',
    ];

    protected array $revisionable = [
        'location_id',
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

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)
            ->using(OrganizationSchedule::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }

    protected function practitionerId(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->practitioners()->first()?->id,
        );
    }
}
