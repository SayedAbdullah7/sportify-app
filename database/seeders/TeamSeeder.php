<?php

namespace Database\Seeders;

use App\Models\Sport;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Team::count() < 1) {
            $users = User::all();
//        $sports = Sport::all();
            Team::factory()
                ->count(7)
                ->create();
            $teams = Team::with('sport.positions')->get();
            foreach ($teams as $team) {
                foreach ($team->sport->positions as $position) {
                    $team->users()->attach($users->random(1)->first(), ['position_id' => $position->id]);

                }
//            $sport = Sport::create(['name' => Str::lower($sportName)]);
//            $sport->positions()->createMany(array_map(function ($position) {
//                return ['name' => Str::lower($position)];
//            }, $positions));
            }
        }
    }
}
