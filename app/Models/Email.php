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

#[ObservedBy([RevisionableObserver::class])]
class Email extends Model implements Revisionable, Sqidable
{
    use HasFactory, HasSqids, LogsRevisions;

    protected $fillable = [
        'email',
    ];

    protected array $revisionable = [
        'email',
    ];

    protected $casts = [
        'email' => 'encrypted',
    ];

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)->using(EmailPerson::class);
    }
}
