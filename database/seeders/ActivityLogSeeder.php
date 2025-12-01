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
                    'action'     => 'Login ke sistem',
                    'ip_address' => '192.168.1.1',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'log_type'   => 'Auth',
                    'created_at' => now(),
                ],
                [
                    'user_id'    => $user->id,
                    'action'     => 'Mengubah profil',
                    'ip_address' => '192.168.1.1',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'log_type'   => 'User',
                    'created_at' => now(),
                ],
                [
                    'user_id'    => $user->id,
                    'action'     => 'Melihat laporan bulanan',
                    'ip_address' => '192.168.1.1',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'log_type'   => 'Report',
                    'created_at' => now(),
                ],
            ]);
        }

        // Contoh log untuk user null (guest / sistem)
        DB::table('activity_logs')->insert([
            'user_id'    => null,
            'action'     => 'Sistem otomatis menjalankan backup',
            'ip_address' => null,
            'user_agent' => null,
            'log_type'   => 'System',
            'created_at' => now(),
        ]);
    }
}

