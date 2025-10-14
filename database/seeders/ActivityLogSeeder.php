<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama (opsional)
        DB::table('activity_logs')->truncate();

        // Ambil beberapa user untuk dijadikan pemilik activity log
        $users = User::take(3)->get();

        foreach ($users as $user) {
            // Buat beberapa log untuk tiap user
            DB::table('activity_logs')->insert([
                [
                    'user_id'    => $user->id,
                    'activity'   => 'Login ke sistem',
                    'ip_address' => '192.168.1.1',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'created_at' => now(),
                ],
                [
                    'user_id'    => $user->id,
                    'activity'   => 'Mengubah profil',
                    'ip_address' => '192.168.1.1',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'created_at' => now(),
                ],
                [
                    'user_id'    => $user->id,
                    'activity'   => 'Melihat laporan bulanan',
                    'ip_address' => '192.168.1.1',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'created_at' => now(),
                ],
            ]);
        }

        // Contoh log untuk user null (guest / sistem)
        DB::table('activity_logs')->insert([
            'user_id'    => null,
            'activity'   => 'Sistem otomatis menjalankan backup',
            'ip_address' => null,
            'user_agent' => null,
            'created_at' => now(),
        ]);
    }
}

