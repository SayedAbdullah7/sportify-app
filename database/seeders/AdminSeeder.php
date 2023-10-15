<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\StadiumOwner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::count() === 0) {
            Admin::factory()
                ->count(15)
                ->create();
        }
    }
}
