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

$allSchedules = CounselingSchedule::where('student_id', $user->id)->get();
echo "Total schedules in database: " . $allSchedules->count() . "\n\n";

if ($allSchedules->count() > 0) {
    echo "All schedules:\n";
    foreach ($allSchedules as $schedule) {
        echo "- Date: {$schedule->scheduled_date}, Status: {$schedule->status}\n";
    }
} else {
    echo "No schedules found for this student.\n";
    echo "\nCreating a test schedule...\n";
    
    // Get a teacher
    $teacher = User::whereIn('role', ['admin', 'guru_bk'])->first();
    
    if ($teacher) {
        CounselingSchedule::create([
            'student_id' => $user->id,
            'teacher_id' => $teacher->id,
            'scheduled_date' => now()->subDays(3)->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '11:00',
            'status' => 'completed',
        ]);
        
        echo "✅ Test schedule created (3 days ago)!\n";
    } else {
        echo "❌ No teacher found to create schedule.\n";
    }
}
