<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Friend>
 */
class FriendFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();
        return [
            'user_id' => $id = $users->random(1)->first()->id,
            'friend_id' => $users->where('id','!=',$id)->random(1)->first()->id,
            'accepted' => fake()->boolean(),
        ];
    }
}
