<?php

namespace App\Sqids;

interface Sqidable
{
    public function getSqidAttribute(): ?string;
    public function getSqidPrefix(): string;
    public function getRouteKey(): string;
    public function resolveRouteBinding($value, $field = null);
}
