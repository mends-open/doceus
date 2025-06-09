<?php

namespace App\Models;

use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([RevisionableObserver::class])]
/**
 * 
 *
 * @property int $id
 * @property int $email_id
 * @property int $person_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailPerson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailPerson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailPerson query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailPerson whereEmailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailPerson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailPerson wherePersonId($value)
 * @mixin \Eloquent
 */
class EmailPerson extends Pivot implements Revisionable
{
    use LogsRevisions;

    public $incrementing = true;

    protected array $revisionable = [
        'email_id',
        'person_id',
    ];
}
