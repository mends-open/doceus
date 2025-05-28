<?php

namespace App\Listeners;

use App\Models\Organization;
use App\Models\Personnel;
use App\Models\Unit;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateDefaultEntitiesForVerifiedUser implements ShouldQueue, ShouldBeEncrypted
{
    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        $user = $event->user;

        $organization = Organization::create();

        $unit = Unit::create([
            'organization_id' => $organization->id,
        ]);

        Personnel::create([
            'user_id' => $user->id,
            'unit_id' => $unit->id,
        ]);
    }
}
