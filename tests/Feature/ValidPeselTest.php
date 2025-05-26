<?php

namespace Tests\Feature;

use App\Rules\ValidPesel;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ValidPeselTest extends TestCase
{
    public function test_valid_pesel_passes(): void
    {
        $data = ['pesel' => '44051401359'];
        $rule = ['pesel' => [new ValidPesel()]];

        $validator = Validator::make($data, $rule);
        $this->assertTrue($validator->passes());
    }

    public function test_invalid_checksum_fails(): void
    {
        $data = ['pesel' => '44051401358'];
        $rule = ['pesel' => [new ValidPesel()]];

        $validator = Validator::make($data, $rule);
        $this->assertFalse($validator->passes());
    }

    public function test_incorrect_length_fails(): void
    {
        $data = ['pesel' => '1234567890'];
        $rule = ['pesel' => [new ValidPesel()]];

        $validator = Validator::make($data, $rule);
        $this->assertFalse($validator->passes());
    }
}
