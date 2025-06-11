<?php

namespace App\Models;

use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Organization;
use App\Models\OrganizationPatient;
use App\Models\PatientTag;
use App\Models\Tag;

class Patient extends BaseModel
{

    protected $fillable = [
        'person_id',
    ];

    protected array $revisionable = [
        'person_id',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->using(PatientTag::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)->using(OrganizationPatient::class);
    }

}
