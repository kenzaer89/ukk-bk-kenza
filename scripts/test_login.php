<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$email = 'kenza@gmail.com';
$password = 'password';

$user = User::where('email', $email)->first();

if (!$user) {
    echo "❌ User not found!\n";
    exit(1);
}

echo "✅ User found: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Role: {$user->role}\n";
echo "\nTesting password...\n";

if (Hash::check($password, $user->password)) {
    echo "✅ Password is CORRECT!\n";
    echo "\nThe login should work. Try these steps:\n";
    echo "1. Clear browser cache (Ctrl+Shift+Delete)\n";
    echo "2. Try incognito/private window\n";
    echo "3. Make sure you're typing: kenza@gmail.com / password\n";
} else {
    echo "❌ Password is INCORRECT!\n";
    echo "Resetting password now...\n";
    $user->password = Hash::make($password);
    $user->save();
    echo "✅ Password reset complete!\n";
}
