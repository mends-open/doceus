<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $person_id
 *
 * @property-read Person $person
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Organization> $organizations
 * @property-read int|null $organizations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Patient> $patients
 * @property-read int|null $patients_count
 */
class Practitioner extends BaseModel
{
    protected $fillable = [
        'person_id',
        'qualifications',
    ];

    protected array $revisionable = [
        'person_id',
        'qualifications',
    ];

    protected $casts = [
        'qualifications' => 'array',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)
            ->using(OrganizationPractitioner::class);
    }

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class)
            ->using(PatientPractitioner::class);
    }
}
