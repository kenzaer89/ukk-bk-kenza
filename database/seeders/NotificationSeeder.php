<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        Notification::truncate();

        $user = User::first();

        Notification::create([
            'user_id' => $user->id,
            'message' => 'Selamat datang di aplikasi BK!',
            'status' => 'unread'
        ]);
    }
}
