<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Command
{
    protected $signature = 'user:reset-password {email}';
    protected $description = 'Reset user password to "password"';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }

        $user->password = Hash::make('password');
        $user->save();

        $this->info("Password reset successfully for: {$user->name} ({$user->email})");
        $this->info("You can now login with: {$email} / password");
        
        return 0;
    }
}
