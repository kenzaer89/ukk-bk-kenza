<?php

use Illuminate\Support\Facades\Hash;
use App\Models\User;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = User::where('email', 'kenza@gmail.com')->first();

if ($user) {
    $user->update(['password' => Hash::make('password')]);
    echo "Password reset successfully for: {$user->email}\n";
    echo "You can now login with: kenza@gmail.com / password\n";
} else {
    echo "User not found!\n";
}
