<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $schedulable_id
 * @property string $schedulable_type
 * @property array $entries
 * @property-read Model|null $schedulable
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

    public function schedulable(): MorphTo
    {
        return $this->morphTo();
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)
            ->using(OrganizationSchedule::class)
            ->withTimestamps();
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class)
            ->using(LocationSchedule::class)
            ->withTimestamps();
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
