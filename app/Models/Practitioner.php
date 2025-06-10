<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Organization;
use App\Models\OrganizationPractitioner;

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
