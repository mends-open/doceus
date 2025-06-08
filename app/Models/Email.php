<?php

namespace App\Models;

use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([RevisionableObserver::class])]
class Email extends Model implements Revisionable
    use HasFactory, LogsRevisions;
    protected array $revisionable = [
        'person_id',
        'email',
    ];

use App\Feature\Revision\Traits\LogsRevisions;
use App\Feature\Sqid\Interfaces\Sqidable;
use App\Feature\Sqid\Traits\HasSqids;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property int $person_id
 * @property mixed $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Person $person
 * @method static \Database\Factories\EmailFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email whereUpdatedAt($value)
 * @mixin \Eloquent
 */

#[ObservedBy([RevisionableObserver::class])]
class Email extends Model implements Revisionable, Sqidable
{
    use HasFactory, HasSqids, LogsRevisions;

    protected $fillable = [
        'person_id',
        'email',
    ];

    protected $casts = [
        'email' => 'encrypted',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
