<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait GenerateName
{
    public function getNameAttribute(): string
    {
        // If 'name' attribute exists and is not empty
        if (! empty($this->name ?? null)) {
            return Str::title($this->name);
        }

        // If both 'first_name' and 'last_name' exist
        if (! empty($this->first_name ?? null) && ! empty($this->last_name ?? null)) {
            return Str::title("{$this->first_name} {$this->last_name}");
        }

        // If only 'first_name' exists
        if (! empty($this->first_name ?? null)) {
            return Str::title($this->first_name);
        }

        // If only 'last_name' exists
        if (! empty($this->last_name ?? null)) {
            return Str::title($this->last_name);
        }

        // If 'email' exists, extract the part before '@' and format it
        if (! empty($this->email ?? null)) {
            $localPart = Str::before($this->email, '@');
            $formatted = preg_replace('/[._-]+/', ' ', $localPart);

            return Str::title($formatted);
        }

        // Fallback to a default name
        return 'User';
    }
}
