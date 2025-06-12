<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use App\Feature\Tags\Enums\TagColor;

/**
 * @property int $id
 * @property int $organization_id
 * @property string $name
 * @property string|null $description
 * @property string $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Patient> $patients
 */

class Tag extends BaseModel
{
    protected $fillable = [
        'organization_id',
        'name',
        'description',
        'color',
    ];

    protected $casts = [
        'color' => TagColor::class,
    ];


    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function patients(): MorphToMany
    {
        return $this->morphedByMany(Patient::class, 'taggable')
            ->using(Taggable::class)
            ->withTimestamps();
    }
}
