<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification as AppNotification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        AppNotification::truncate();

        $user = User::first();

        AppNotification::create([
            'user_id' => $user->id,
            'message' => 'Selamat datang di aplikasi BK!',
            'status' => 'unread'
        ]);
    }
}
