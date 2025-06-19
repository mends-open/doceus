<?php

namespace App\Models;

use App\Feature\Identity\Enums\LocationType;
use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends BaseModel
{
    protected $fillable = [
        'organization_id',
        'name',
        'type',
        'address',
        'description',
    ];

    protected array $revisionable = [
        'name',
        'type',
        'address',
        'description',
    ];

    protected $casts = [
        'type'    => LocationType::class,
        'address' => 'array',
        'active'  => 'boolean',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
