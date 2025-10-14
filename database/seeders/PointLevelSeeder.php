<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PointLevel;

class PointLevelSeeder extends Seeder
{
    public function run(): void
    {
        PointLevel::truncate();

        PointLevel::create(['point_threshold'=>10,'action'=>'Peringatan Guru']);
        PointLevel::create(['point_threshold'=>20,'action'=>'Panggilan Orang Tua']);
    }
}

