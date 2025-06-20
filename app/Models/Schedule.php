<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $organization_id
 * @property int|null $location_id
 * @property int|null $practitioner_id
 * @property array $entries
 * @property-read Practitioner|null $practitioner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Slot> $slots
 * @property-read int|null $slots_count
 */
class Schedule extends BaseModel
{
    protected $fillable = [
        'organization_id',
        'location_id',
        'practitioner_id',
        'entries',
    ];

    protected array $revisionable = [
        'organization_id',
        'location_id',
        'practitioner_id',
        'entries',
    ];

    protected $casts = [
        'entries' => 'array',
    ];

    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }

    /**
     * Export schedule entries as a simple RFC5545 iCalendar string.
     */
    public function toIcs(): string
    {
        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Doceus//Schedule//EN',
        ];

        foreach ($this->entries as $entry) {
            $lines[] = 'BEGIN:VEVENT';

            if ($entry['type'] === 'weekly') {
                $start = Carbon::parse($entry['start_date'].' '.$entry['start_time']);
                $end = Carbon::parse($entry['start_date'].' '.$entry['end_time']);

                $lines[] = 'DTSTART:'.$start->format('Ymd\THis');
                $lines[] = 'DTEND:'.$end->format('Ymd\THis');

                $days = collect($entry['days'] ?? [])
                    ->map(fn (int $d) => Carbon::create()->startOfWeek()->addDays($d - 1)->format('D'))
                    ->implode(',');

                $rule = 'FREQ=WEEKLY;BYDAY='.strtoupper($days);

                if (($entry['has_end_date'] ?? false) && isset($entry['end_date'])) {
                    $rule .= ';UNTIL='.Carbon::parse($entry['end_date'])->format('Ymd');
                }

                $lines[] = 'RRULE:'.$rule;
            } elseif ($entry['type'] === 'one_time') {
                $lines[] = 'DTSTART:'.Carbon::parse($entry['date'].' '.$entry['start_time'])->format('Ymd\THis');
                $lines[] = 'DTEND:'.Carbon::parse($entry['date'].' '.$entry['end_time'])->format('Ymd\THis');
            } elseif ($entry['type'] === 'block') {
                if ($entry['full_day'] ?? false) {
                    $start = Carbon::parse($entry['date']);
                    $lines[] = 'DTSTART;VALUE=DATE:'.$start->format('Ymd');
                    $lines[] = 'DTEND;VALUE=DATE:'.$start->copy()->addDay()->format('Ymd');
                } else {
                    $lines[] = 'DTSTART:'.Carbon::parse($entry['date'].' '.$entry['start_time'])->format('Ymd\THis');
                    $lines[] = 'DTEND:'.Carbon::parse($entry['date'].' '.$entry['end_time'])->format('Ymd\THis');
                }
            }

            $lines[] = 'END:VEVENT';
        }

        $lines[] = 'END:VCALENDAR';

        return implode("\r\n", $lines);
    }
}
