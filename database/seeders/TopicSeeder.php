<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key checks sementara
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Topic::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $topics = [
            'Akademik dan Prestasi',
            'Kedisiplinan dan Perilaku',
            'Kesehatan Mental dan Emosional',
            'Hubungan Sosial dan Keluarga',
            'Karier dan Masa Depan'
        ];

        foreach ($topics as $topic) {
            Topic::create([
                'name' => $topic,
            ]);
        }
    }
}
