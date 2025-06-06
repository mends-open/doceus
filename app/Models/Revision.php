<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;

class Revision extends Model
{

    protected $fillable = [
        'created_at',
        'user_id',
        'organization_id',
        'revisionable_type',
        'revisionable_id',
        'data',
    ];

    public $timestamps = false;

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
