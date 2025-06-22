<?php

namespace App\Models;

use App\Feature\Identity\Enums\LocationType;
use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $organization_id
 * @property string|null $name
 * @property LocationType $type
 * @property array|null $address
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Organization $organization
 */
class Location extends BaseModel
{
    protected $fillable = [
        'organization_id',
        'name',
        'type',
        'address',
        'description',
    ];

    protected array $revisionable = [
        'name',
        'type',
        'address',
        'description',
    ];

    protected $casts = [
        'type' => LocationType::class,
        'address' => 'array',
        'active' => 'boolean',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
