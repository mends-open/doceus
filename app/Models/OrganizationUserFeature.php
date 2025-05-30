<?php

namespace App\Models;

use App\Enums\FeatureEvent;
use App\Enums\UserFeature;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrganizationUserFeature extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'organization_user_features';

    protected $guarded = [];

    public $incrementing = false;

    protected $casts = [
        'feature' => UserFeature::class,
        'event' => FeatureEvent::class,
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
