<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Database\Factories\OrganizationFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Feature\Identity\Enums\OrganizationType;
use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use App\Feature\Sqid\Interfaces\Sqidable;
use App\Feature\Sqid\Traits\HasSqids;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Practitioner;
use App\Models\OrganizationPractitioner;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property OrganizationType $type
 * @property mixed $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read string|null $sqid
 * @property-read Collection<int, Person> $people
 * @property-read int|null $people_count
 * @property-read OrganizationPractitioner|null $pivot
 * @property-read Collection<int, Practitioner> $practitioners
 * @property-read int|null $practitioners_count
 * @method static OrganizationFactory factory($count = null, $state = [])
 * @method static Builder<static>|Organization newModelQuery()
 * @method static Builder<static>|Organization newQuery()
 * @method static Builder<static>|Organization onlyTrashed()
 * @method static Builder<static>|Organization query()
 * @method static Builder<static>|Organization whereCreatedAt($value)
 * @method static Builder<static>|Organization whereDeletedAt($value)
 * @method static Builder<static>|Organization whereId($value)
 * @method static Builder<static>|Organization whereName($value)
 * @method static Builder<static>|Organization whereType($value)
 * @method static Builder<static>|Organization whereUpdatedAt($value)
 * @method static Builder<static>|Organization withTrashed()
 * @method static Builder<static>|Organization withoutTrashed()
 * @mixin \Eloquent
 */
class Organization extends BaseModel
{
    protected $casts = [
        'type' => OrganizationType::class,
        'name' => 'encrypted',
    ];

    protected $fillable = [
        'type',
        'name',
    ];

    protected array $revisionable = [
        'type',
        'name',
    ];

    public function practitioners(): BelongsToMany
    {
        return $this->belongsToMany(Practitioner::class)
            ->using(OrganizationPractitioner::class);
    }

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }
}
