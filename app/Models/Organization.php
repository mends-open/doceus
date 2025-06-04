<?php

namespace App\Models;

use App\Enums\OrganizationType;
use App\Sqids\HasSqid;
use App\Sqids\Sqidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property string $id
 * @property OrganizationType $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Organization extends Model implements Sqidable
{
    use HasFactory, HasSqid;

    protected $guarded = [];

    protected $casts = [
        'type' => OrganizationType::class,
    ];

    protected static string $sqidPrefixBase = 'org';

    public function getNameAttribute(): string
    {
        return $this->type?->label() ?? '';
    }

    public function getFilamentName(): string
    {
        return $this->type?->label() ?? '';
    }

    public function users(): BelongsToMany
    {
        return $this->BelongsToMany(User::class)->using(OrganizationUser::class);
    }
}
