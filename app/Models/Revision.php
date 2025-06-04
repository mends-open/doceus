<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Revision extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'created_at',
        'user_id',
        'revisionable_type',
        'revisionable_id',
        'revisionable_attribute',
        'type',
        'data',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
