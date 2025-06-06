<?php

namespace App\Models;

use App\Contracts\Sqids\Sqidable;
use App\Enums\OrganizationType;
use App\Services\Revisions\LogsRevisions;
use App\Traits\Sqids\HasSqid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property OrganizationType $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Organization extends Model implements Sqidable
{
    use HasFactory, HasSqid, LogsRevisions, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'type' => OrganizationType::class,
        'name' => 'encrypted',
    ];

    protected $fillable = [
        'type',
        'name',
    ];

    public function users(): BelongsToMany
    {
        return $this->BelongsToMany(User::class)->using(OrganizationUser::class);
    }

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }
}
