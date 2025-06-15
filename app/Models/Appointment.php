<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $patient_id
 * @property int $practitioner_id
 * @property int $organization_id
 * @property Carbon|null $scheduled_at
 * @property-read Patient $patient
 * @property-read Practitioner $practitioner
 * @property-read Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Encounter> $encounters
 */
class Appointment extends BaseModel
{
    protected $fillable = [
        'patient_id',
        'practitioner_id',
        'organization_id',
        'scheduled_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function encounters(): HasMany
    {
        return $this->hasMany(Encounter::class);
    }
}
