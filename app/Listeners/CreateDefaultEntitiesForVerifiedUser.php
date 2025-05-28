<?php

namespace App\Listeners;

use App\Enums\OrganizationType;
use App\Enums\PersonnelType;
use App\Enums\UnitType;
use App\Models\Organization;
use App\Models\Personnel;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateDefaultEntitiesForVerifiedUser implements ShouldBeEncrypted, ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        $user = $event->user;

        // Only create if the user does not already have a medical doctor personnel
        if ($user->personnel()->where('type', PersonnelType::MEDICAL_DOCTOR)->exists()) {
            return;
        }

        DB::transaction(function () use ($user) {
            $organization = Organization::create([
                'type' => OrganizationType::NATURAL_PERSON,
            ]);

            $unit = Unit::create([
                'organization_id' => $organization->id,
                'type' => UnitType::WITHOUT_PRACTICE,
            ]);

            Personnel::create([
                'user_id' => $user->id,
                'unit_id' => $unit->id,
                'type' => PersonnelType::MEDICAL_DOCTOR,
            ]);
        });
    }
}
