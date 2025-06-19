<?php

namespace App\Listeners;

use App\Models\Person;
use App\Models\Practitioner;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\DB;

class CreateIdentityAfterLogin implements ShouldHandleEventsAfterCommit
{
    public function handle(Login $event): void
    {
        /** @var User $user */
        $user = $event->user;

        if ($user->practitioner()->exists()) {
            return;
        }

        DB::transaction(function () use ($user) {
            if (! $user->person_id) {
                $user->person()->associate(Person::create());
                $user->save();
            }

            $user->person->update(Person::factory()->make()->toArray());

            $user->practitioner()->create(['person_id' => $user->person_id]);
        });
    }
}
