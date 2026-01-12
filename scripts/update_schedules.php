<?php

use App\Models\User;
use App\Models\CounselingSchedule;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = User::where('email', 'kenza@gmail.com')->first();

if (!$user) {
    echo "❌ User not found!\n";
    exit(1);
}

echo "✅ User: {$user->name} (ID: {$user->id})\n\n";

// Update existing schedules to be in the past
$updated = CounselingSchedule::where('student_id', $user->id)
    ->update([
        'scheduled_date' => now()->subDays(2)->format('Y-m-d'),
        'status' => 'completed'
    ]);

echo "✅ Updated {$updated} schedule(s) to be completed and 2 days ago.\n\n";

// Show all schedules
$allSchedules = CounselingSchedule::where('student_id', $user->id)->get();
echo "All schedules for this student:\n";
foreach ($allSchedules as $schedule) {
    echo "- Date: {$schedule->scheduled_date}, Time: {$schedule->start_time}-{$schedule->end_time}, Status: {$schedule->status}\n";
}

echo "\n✅ Done! Refresh the dashboard to see the counseling history.\n";
