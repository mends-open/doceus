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
 * @property int $person_id
 * @property int $phone_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonPhone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonPhone wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonPhone wherePhoneId($value)
 * @mixin \Eloquent
 */
class PersonPhone extends Pivot implements Revisionable
{
    use LogsRevisions;

    public $incrementing = true;

    protected array $revisionable = [
        'person_id',
        'phone_id',
    ];
}
