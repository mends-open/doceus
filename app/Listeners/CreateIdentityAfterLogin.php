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
        if (! $event->user instanceof User) {
            return;
        }

        $user = $event->user;

        if ($user->practitioner()->exists()) {
            return;
        }

        DB::transaction(function () use ($user) {
            if (! $user->person_id) {
                $user->person()->associate(Person::create());
                $user->save();
            }

            $user->practitioner()->create([
                'person_id' => $user->person_id,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'password' => $user->password,
                'language' => $user->language,
                'email_verified_at' => $user->email_verified_at,
                'remember_token' => $user->remember_token,
            ]);
        });
    }
}
