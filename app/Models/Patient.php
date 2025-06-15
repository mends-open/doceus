<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $person_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Person $person
 * @property-read Collection<int, Organization> $organizations
 */
class Patient extends BaseModel
{
    protected $fillable = [
        'person_id',
    ];

    protected array $revisionable = [
        'person_id',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)->using(OrganizationPatient::class);
    }
}
