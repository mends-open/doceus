<?php

namespace App\Models;

use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ContactPoint;
use App\Feature\Identity\Enums\ContactableType;
use App\Models\Organization;
use App\Models\OrganizationPatient;

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

    public function contactPoints(): HasMany
    {
        return $this->hasMany(ContactPoint::class, 'contactable_id', 'person_id')->where('contactable_type', ContactableType::Person);
    }

}
