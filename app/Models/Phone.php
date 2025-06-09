<?php

namespace App\Models;

use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use App\Feature\Sqid\Interfaces\Sqidable;
use App\Feature\Sqid\Traits\HasSqids;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Person;
use App\Models\PersonPhone;

#[ObservedBy([RevisionableObserver::class])]
/**
 * 
 *
 * @property int $id
 * @property mixed $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string|null $sqid
 * @property-read PersonPhone|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Person> $person
 * @property-read int|null $person_count
 * @method static \Database\Factories\PhoneFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Phone extends Model implements Sqidable, Revisionable
{
    use HasFactory, HasSqids, LogsRevisions;

    protected $fillable = [
        'phone',
    ];

    protected array $revisionable = [
        'phone',
    ];

    protected $casts = [
        'phone' => 'encrypted',
    ];

    public function person(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)->using(PersonPhone::class);
    }

}
