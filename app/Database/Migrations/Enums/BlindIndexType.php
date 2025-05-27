<?php

namespace App\Database\Migrations\Enums;

enum BlindIndexType
{
    case NULLABLE;
    case NOT_NULL;
    case NOT_NULL_UNIQUE;
    case NULLABLE_UNIQUE;

    public function isNullable(): bool
    {
        return match ($this) {
            self::NULLABLE, self::NULLABLE_UNIQUE => true,
            default => false,
        };
    }

    public function isUnique(): bool
    {
        return match ($this) {
            self::NOT_NULL_UNIQUE, self::NULLABLE_UNIQUE => true,
            default => false,
        };
    }
}
