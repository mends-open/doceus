<?php

namespace App\Models;

use App\Feature\Identity\Enums\PractitionerQualification as PractitionerQualificationEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'qualification' => PractitionerQualificationEnum::class,
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(Practitioner::class);
    }
}
