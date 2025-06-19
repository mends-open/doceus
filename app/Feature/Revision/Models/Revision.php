<?php

namespace App\Feature\Revision\Models;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon $dispatched_at
 * @property string $created_at
 * @property int|null $organization_id
 * @property int|null $user_id
 * @property int|null $revisionable_id
 * @property string $revisionable_type
 * @property string $type
 * @property array<array-key, mixed>|null $data
 * @property string|null $meta
 * @property string|null $session_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $url
 * @property-read Organization|null $organization
 * @property-read Model|\Eloquent|null $revisionable
 * @property-read User|null $user
 *
 * @method static Builder<static>|Revision newModelQuery()
 * @method static Builder<static>|Revision newQuery()
 * @method static Builder<static>|Revision query()
 * @method static Builder<static>|Revision whereCreatedAt($value)
 * @method static Builder<static>|Revision whereData($value)
 * @method static Builder<static>|Revision whereDispatchedAt($value)
 * @method static Builder<static>|Revision whereId($value)
 * @method static Builder<static>|Revision whereIpAddress($value)
 * @method static Builder<static>|Revision whereMeta($value)
 * @method static Builder<static>|Revision whereOrganizationId($value)
 * @method static Builder<static>|Revision whereRevisionableId($value)
 * @method static Builder<static>|Revision whereRevisionableType($value)
 * @method static Builder<static>|Revision whereSessionId($value)
 * @method static Builder<static>|Revision whereType($value)
 * @method static Builder<static>|Revision whereUrl($value)
 * @method static Builder<static>|Revision whereUserAgent($value)
 * @method static Builder<static>|Revision whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Revision extends Model
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
        'session_id',
        'ip_address',
        'user_agent',
        'url',
    ];

    protected $casts = [
        'data' => 'json',
        'dispatched_at' => 'datetime:Y-m-d H:i:s.u',
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
