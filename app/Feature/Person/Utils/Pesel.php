<?php

namespace App\Feature\Person\Utils;

use App\Feature\Person\Enums\Gender;
use Carbon\Carbon;

class Pesel
{
    public static function isValid(string $pesel): bool
    {
        if (!preg_match('/^\d{11}$/', $pesel)) {
            return false;
        }

        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $weights[$i] * (int) $pesel[$i];
        }
        $control = (10 - ($sum % 10)) % 10;

        return $control === (int) $pesel[10];
    }

    public static function extractBirthDate(string $pesel): ?Carbon
    {
        if (!self::isValid($pesel)) {
            return null;
        }

        $year = (int) substr($pesel, 0, 2);
        $month = (int) substr($pesel, 2, 2);
        $day = (int) substr($pesel, 4, 2);

        $century = 1900;
        if ($month > 80) {
            $century = 1800;
            $month -= 80;
        } elseif ($month > 60) {
            $century = 2200;
            $month -= 60;
        } elseif ($month > 40) {
            $century = 2100;
            $month -= 40;
        } elseif ($month > 20) {
            $century = 2000;
            $month -= 20;
        }

        $year += $century;

        return Carbon::create($year, $month, $day);
    }

    public static function extractGender(string $pesel): ?Gender
    {
        if (!self::isValid($pesel)) {
            return null;
        }

        $digit = (int) $pesel[9];
        return ($digit % 2) ? Gender::Male : Gender::Female;
    }
}
