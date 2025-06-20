<?php

namespace App\Models;

use App\Feature\Scheduling\Enums\SlotStatus;
use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $schedule_id
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property SlotStatus $status
 * @property-read Schedule $schedule
 */
class Slot extends BaseModel
{
    protected $fillable = [
        'schedule_id',
        'start_at',
        'end_at',
        'status',
    ];

    protected array $revisionable = [
        'schedule_id',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'status' => SlotStatus::class,
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function organization(): ?Organization
    {
        return $this->schedule?->location?->organization;
    }
}
