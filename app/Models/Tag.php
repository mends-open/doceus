<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends BaseModel
{
    protected $fillable = [
        'organization_id',
        'name',
        'description',
        'color',
        'icon',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function patients(): MorphToMany
    {
        return $this->morphedByMany(Patient::class, 'taggable')
            ->using(Taggable::class);
    }
}
