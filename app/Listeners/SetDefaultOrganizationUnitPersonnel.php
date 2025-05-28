<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Organization;
use App\Models\Unit;
use App\Models\Personnel;

return new class implements ShouldQueue, ShouldBeEncrypted
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        // Extract the user from the event payload
        $user = $event->user;

        // Step 1: Create an Organization with user_id as the user
        $organization = Organization::create([
        ]);

        // Step 2: Create a Unit associated with the organization
        $unit = Unit::create([
            'organization_id' => $organization->id,
        ]);

        // Step 3: Create Personnel associated with the user and unit
        Personnel::create([
            'user_id' => $user->id,
            'unit_id' => $unit->id,
        ]);
    }
};
