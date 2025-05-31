<?php

namespace App\Models;

use App\Enums\FeatureEvent;
use App\Enums\OrganizationFeature as OrganizationFeatureEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationFeatureEvent extends Model
{
    use HasFactory, HasUuids;

    protected $casts = [
        'feature' => OrganizationFeatureEnum::class,
        'event' => FeatureEvent::class,
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
