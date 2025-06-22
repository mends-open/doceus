<?php

namespace App\Models;

use App\Feature\Identity\Enums\LocationType;
use App\Feature\Identity\Enums\OrganizationType;
use App\Models\Base\BaseModel;
use Database\Factories\OrganizationFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
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
 *
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
 *
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

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    protected static function booted(): void
    {
        static::created(function (Organization $organization) {
            $organization->locations()->create([
                'type' => LocationType::Virtual,
            ]);
        });
    }

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }
}
