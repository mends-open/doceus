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
 * @property Carbon|null $end_date
 * @property string $start_time
 * @property string $end_time
 * @property array $days_of_week
 * @property RepeatPattern $repeat_pattern
 * @property-read Practitioner $practitioner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Slot> $slots
 * @property-read int|null $slots_count
 */
class Schedule extends BaseModel
{
    protected $fillable = [
        'practitioner_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'days_of_week',
        'repeat_pattern',
    ];

    protected array $revisionable = [
        'practitioner_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'days_of_week',
        'repeat_pattern',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'days_of_week' => 'array',
        'repeat_pattern' => RepeatPattern::class,
    ];

    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
