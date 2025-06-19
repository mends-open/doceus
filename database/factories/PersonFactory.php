<?php

namespace Database\Factories;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\IdentityType;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        $genders = array_map(fn ($g) => $g->value, Gender::cases());
        $identityTypes = array_map(fn ($t) => $t->value, IdentityType::cases());

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'pesel' => $this->faker->numerify('###########'),
            'identity_number' => $this->faker->numerify('AA######'),
            'identity_type' => $this->faker->randomElement($identityTypes),
            'gender' => $this->faker->randomElement($genders),
            'birth_date' => $this->faker->date(),
        ];
    }
}
