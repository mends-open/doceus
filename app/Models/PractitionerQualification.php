<?php

namespace App\Models;

use App\Feature\Identity\Enums\PrectitionerQualification;
use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Practitioner;

class PractitionerQualification extends BaseModel
{
    protected $fillable = [
        'practitioner_id',
        'qualification',
        'valid_from',
        'valid_to',
    ];

    protected array $revisionable = [
        'practitioner_id',
        'qualification',
        'valid_from',
        'valid_to',
    ];

    protected $casts = [
        'qualification' => PrectitionerQualification::class,
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(Practitioner::class);
    }
}
