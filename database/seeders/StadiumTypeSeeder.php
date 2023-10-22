<?php

namespace Database\Seeders;

use App\Models\StadiumOwner;
use App\Models\StadiumType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StadiumTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (StadiumType::count() < 1){
            StadiumType::factory()
                ->count(15)
                ->create();
        }
    }
}
