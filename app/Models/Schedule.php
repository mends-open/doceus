<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $practitioner_id
 * @property int $organization_id
 * @property int $location_id
 * @property array $entries
 * @property-read Practitioner $practitioner
 * @property-read Organization $organization
 * @property-read Location $location
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Slot> $slots
 * @property-read int|null $slots_count
 */
class Schedule extends BaseModel
{
    protected $fillable = [
        'practitioner_id',
        'organization_id',
        'location_id',
        'entries',
    ];

    protected array $revisionable = [
        'practitioner_id',
        'organization_id',
        'location_id',
        'entries',
    ];

    protected $casts = [
        'entries' => 'array',
    ];

    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
