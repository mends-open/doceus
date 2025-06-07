<?php

namespace App\Models\Revisions;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ModelRevision extends Model
{
    public $timestamps = false;

    public $fillable = [
        'dispatched_at',
        'organization_id',
        'user_id',
        'revisionable_type',
        'revisionable_id',
        'type',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];

    /**
     * Get the parent revisionable model (morph-to).
     */
    public function revisionable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who made the revision.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
