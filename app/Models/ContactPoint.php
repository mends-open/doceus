<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\ContactPointFactory;
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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Person $person
 * @method static ContactPointFactory factory($count = null, $state = [])
 */
class ContactPoint extends BaseModel
{
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

    protected static function booted(): void
    {
        parent::booted();

        static::creating(function (self $point) {
            if (! $point->contactable_type) {
                $point->contactable_type = ContactableType::Person;
            }
        });
    }
}
