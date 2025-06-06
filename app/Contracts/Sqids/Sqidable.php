<?php

namespace App\Contracts\Sqids;

interface Sqidable
{
    public function getSqidAttribute(): ?string;

    public function getRouteKey(): string;

    public function resolveRouteBinding($value, $field = null);
}
