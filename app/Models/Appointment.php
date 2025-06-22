<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $organization_id
 * @property-read Organization $organization
 */
class Appointment extends BaseModel
{
    protected $fillable = [
        'organization_id',
    ];

    protected array $revisionable = [
        'organization_id',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
