<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $appointment_id
 * @property string|null $notes
 * @property-read Appointment $appointment
 */
class Encounter extends BaseModel
{
    protected $fillable = [
        'appointment_id',
        'notes',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
