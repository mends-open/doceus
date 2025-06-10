<?php

namespace Tests\Feature;

use App\Feature\Identity\Services\Pesel;
use App\Feature\Identity\Enums\Gender;
use Tests\TestCase;
use Carbon\Carbon;

class PeselServiceTest extends TestCase
{
    public function test_extract_birth_date_from_valid_pesel(): void
    {
        $birthDate = Pesel::extractBirthDate('44051401359');
        $this->assertInstanceOf(Carbon::class, $birthDate);
        $this->assertSame('1944-05-14', $birthDate->format('Y-m-d'));
    }

    public function test_extract_birth_date_returns_null_for_invalid_pesel(): void
    {
        $this->assertNull(Pesel::extractBirthDate('1234567890'));
    }

    public function test_extract_gender_from_valid_pesel(): void
    {
        $gender = Pesel::extractGender('44051401359');
        $this->assertSame(Gender::Male, $gender);
    }

    public function test_extract_gender_returns_null_for_invalid_pesel(): void
    {
        $this->assertNull(Pesel::extractGender('invalid'));
    }
}
