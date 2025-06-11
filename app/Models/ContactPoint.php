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
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use App\Models\Patient;

/**
 * @property int $id
 * @property int|null $contactable_id
 * @property ContactableType|null $contactable_type
 * @property ContactPointSystem $system
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Person $person
 * @property-read Model|\App\Models\Organization|Person|null $contactable
 * @property-read Patient|null $patient
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

    public function scopeUnused($query)
    {
        return $query->whereNull('contactable_id');
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'contactable_id')
            ->where('contactable_type', ContactableType::Person);
    }

    public function contactable(): MorphTo
    {
        return $this->morphTo();
    }

    public function patient(): HasOneThrough
    {
        return $this->hasOneThrough(
            Patient::class,
            Person::class,
            'id',
            'person_id',
            'contactable_id',
            'id'
        )->where('contactable_type', ContactableType::Person);
    }

    protected static function booted(): void
    {
        parent::booted();

        static::saving(function (self $point) {
            if (blank($point->contactable_id)) {
                $point->contactable_type = null;
            } elseif (! $point->contactable_type) {
                $point->contactable_type = ContactableType::Person;
            }
        });
    }
}
