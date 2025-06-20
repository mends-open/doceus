<?php

use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('exports schedule to RFC5545 iCalendar', function () {
    $schedule = Schedule::factory()->create([
        'entries' => [
            [
                'type' => 'one_time',
                'date' => '2025-07-01',
                'start_time' => '09:00',
                'end_time' => '10:00',
            ],
        ],
    ]);

    $ics = $schedule->toIcs();

    expect($ics)
        ->toContain('BEGIN:VCALENDAR')
        ->toContain('BEGIN:VEVENT')
        ->toContain('DTSTART:20250701T090000')
        ->toContain('DTEND:20250701T100000')
        ->toContain('END:VEVENT')
        ->toContain('END:VCALENDAR');
});
