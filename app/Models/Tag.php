<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Patient> $patients
 * @property-read int|null $patients_count
 */
class Tag extends BaseModel
{
    protected $fillable = [
        'name',
        'color',
    ];

    protected array $revisionable = [
        'name',
        'color',
    ];

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class)->using(PatientTag::class);
    }
}
