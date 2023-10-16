<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StadiumOwner>
 */
class StadiumOwnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('ar_EG'); // for Arabic
        return [
            'name' => $faker->name(),
            'phone'=> $removed = Str::remove('+', $faker->unique()->e164PhoneNumber()),
        ];
    }
}
