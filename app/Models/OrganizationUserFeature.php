<?php

namespace App\Models;

use App\Enums\FeatureEvent;
use App\Enums\UserFeature;
use App\Events\MaterializedViewNeedsRefresh;
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
    public $timestamps = false;

    protected $fillable = [
        'organization_id',
        'user_id',
        'feature',
        'event',
        'created_by',
    ];

    protected static function booted(): void
    {
        static::created(function (): void {
            event(new MaterializedViewNeedsRefresh('organization_user'));
        });
    }

    protected $casts = [
        'feature' => UserFeature::class,
        'event' => FeatureEvent::class,
    ];

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)
            ->using(OrganizationUser::class);
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
