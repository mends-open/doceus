<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $person_id
 * @property-read Person $person
 * @property-read Collection<int, Organization> $organizations
 * @property-read int|null $organizations_count
 */
class Practitioner extends BaseModel
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
        return $this->belongsToMany(Organization::class)->using(OrganizationPractitioner::class);
    }
}
