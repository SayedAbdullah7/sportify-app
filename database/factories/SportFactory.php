<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sport>
 */
class SportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sports = [
            'football',
            'basketball',
            'baseball',
            'soccer',
            'tennis',
            'volleyball',
            'golf',
            'hockey',
            'cricket',
            'rugby',
            'swimming',
            'cycling',
            'athletics',
            'badminton',
            'table tennis',
            'boxing',
            'wrestling',
            'gymnastics',
            'skiing',
            'snowboarding',
            'surfing',
            'skateboarding',
            'archery',
            'shooting',
            'equestrian',
            'weightlifting',
            'karate',
            'judo',
            'taekwondo',
            'fencing',
            'canoeing',
            'kayaking',
            'sailing',
            'rowing',
            'triathlon',
            'pentathlon',
            'bobsleigh',
            'luge',
            'skeleton',
            'curling',
            'figure skating',
            'ice hockey',
            'freestyle skiing',
            'biathlon',
            'water polo',
            'polo',
            'snooker',
            'billiards',
        ];

        return [
            'name' => fake()->unique()->randomElement($sports),
        ];
    }
}
