<?php

namespace Database\Seeders;

use App\Models\Sport;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $sports = Sport::all();
        foreach ($users as $user ){
            foreach ($sports->random(3) as $sport){
                $user->sports()->attach($sport->id);
            }
        }
    }
}
