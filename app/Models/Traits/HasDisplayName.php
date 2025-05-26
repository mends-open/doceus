<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasDisplayName
{
    public function getNameAttribute(): string
    {
        if (! empty($this->name ?? null)) {
            return Str::title($this->name);
        }

        if (! empty($this->first_name ?? null) && ! empty($this->last_name ?? null)) {
            return Str::title("{$this->first_name} {$this->last_name}");
        }

        if (! empty($this->first_name ?? null)) {
            return Str::title($this->first_name);
        }

        if (! empty($this->last_name ?? null)) {
            return Str::title($this->last_name);
        }

        if (! empty($this->email ?? null)) {
            $local = Str::before($this->email, '@');
            $clean = preg_replace('/[._-]+/', ' ', $local);

            return Str::title($clean);
        }

        return 'User';
    }
}
