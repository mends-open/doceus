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
