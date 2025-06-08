<?php

namespace App\Models;

use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Person;
use App\Models\PersonPhone;
    public function persons(): BelongsToMany
        return $this->belongsToMany(Person::class)->using(PersonPhone::class);

/**
 *
 *
 * @property int $id
 * @property int $person_id
 * @property mixed $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Person $person
 * @method static \Database\Factories\PhoneFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone whereUpdatedAt($value)
 * @mixin \Eloquent
 */

#[ObservedBy([RevisionableObserver::class])]
class Phone extends Model implements Sqidable, Revisionable
{
    use HasFactory, HasSqids, LogsRevisions;

    protected $fillable = [
        'person_id',
        'phone',
    ];

    protected $casts = [
        'phone' => 'encrypted',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
