<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\StadiumOwner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StadiumOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (StadiumOwner::count() < 1){
//            StadiumOwner::factory()
//                ->count(15)
//                ->create();
        }

    }
}
