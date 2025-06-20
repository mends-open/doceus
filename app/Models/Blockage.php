<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * One-time availability override
 *
 * @property int $id
 * @property int $schedule_id
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property string|null $reason
 * @property-read Schedule $schedule
 */
class Blockage extends BaseModel
{
    protected $fillable = [
        'schedule_id',
        'start_at',
        'end_at',
        'reason',
    ];

    protected array $revisionable = [
        'schedule_id',
        'start_at',
        'end_at',
        'reason',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
