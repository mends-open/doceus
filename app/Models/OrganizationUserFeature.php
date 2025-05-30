<?php

namespace App\Models;

use App\Enums\FeatureEvent;
use App\Enums\UserFeature;
use App\Events\MaterializedViewNeedsRefresh;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationUserFeature extends Pivot
{
    use HasFactory, HasUuids;

    protected $table = 'organization_user_features';

    protected $guarded = [];

    public $incrementing = false;

    protected static function booted(): void
    {
        static::created(function (): void {
            event(new MaterializedViewNeedsRefresh('organization_users'));
        });
    }

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
