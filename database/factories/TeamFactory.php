<?php

namespace Database\Factories;

use App\Models\Sport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();
        $sports = Sport::all();

        return [
            'name' => $this->faker->unique()->word(),
            'user_id' => $users->random(1)->first()->id,
            'sport_id' => $sports->random(1)->first()->id,
        ];
    }
}
