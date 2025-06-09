<?php

namespace App\Models;

use App\Feature\Identity\Enums\ContactPointSystem;
use App\Feature\Identity\Enums\ContactableType;
use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $contactable_id
 * @property ContactableType $contactable_type
 * @property ContactPointSystem $system
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Person $person
 * @method static \Database\Factories\ContactPointFactory factory($count = null, $state = [])
 */
#[ObservedBy([RevisionableObserver::class])]
class ContactPoint extends Model implements Revisionable
{
    use HasFactory, LogsRevisions;

    protected $fillable = [
        'contactable_id',
        'contactable_type',
        'system',
        'value',
    ];

    protected array $revisionable = [
        'contactable_id',
        'contactable_type',
        'system',
        'value',
    ];

    protected $casts = [
        'contactable_type' => ContactableType::class,
        'system' => ContactPointSystem::class,
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'contactable_id')
            ->where('contactable_type', ContactableType::Person);
    }
}
