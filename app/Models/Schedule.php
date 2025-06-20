<?php

namespace App\Models;

use App\Feature\Scheduling\Enums\RepeatPattern;
use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $practitioner_id
 * @property Carbon $start_date
 * @property Carbon|null $repeat_until
 * @property string $start_time
 * @property string $end_time
 * @property array $days_of_week
 * @property RepeatPattern $repeat_pattern
 * @property bool $is_blocking
 * @property-read Practitioner $practitioner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Slot> $slots
 * @property-read int|null $slots_count
 */
class Schedule extends BaseModel
{
    protected $fillable = [
        'practitioner_id',
        'start_date',
        'start_time',
        'end_time',
        'repeat_until',
        'days_of_week',
        'repeat_pattern',
        'is_blocking',
    ];

    protected array $revisionable = [
        'practitioner_id',
        'start_date',
        'start_time',
        'end_time',
        'repeat_until',
        'days_of_week',
        'repeat_pattern',
        'is_blocking',
    ];

    protected $casts = [
        'start_date' => 'date',
        'repeat_until' => 'date',
        'days_of_week' => 'array',
        'repeat_pattern' => RepeatPattern::class,
        'is_blocking' => 'boolean',
    ];

    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
