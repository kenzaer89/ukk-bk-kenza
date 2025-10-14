<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         // 🚫 Matikan sementara semua foreign key check
        Schema::disableForeignKeyConstraints();

        $this->call([
            UserSeeder::class,
            ClassSeeder::class,
            ParentStudentSeeder::class,
            CounselingRequestSeeder::class,
            CounselingScheduleSeeder::class,
            CounselingSessionSeeder::class,
            TopicSeeder::class,
            SessionTopicSeeder::class,
            BkVisitSeeder::class,
            NotificationSeeder::class,
            AttachmentSeeder::class,
            RuleSeeder::class,
            ViolationSeeder::class,
            PointLevelSeeder::class,
            AchievementSeeder::class,
            StudentHistorySeeder::class,
            MonthlyReportSeeder::class,
            ActivityLogSeeder::class
        ]);

        // ✅ Aktifkan lagi FK setelah selesai
        Schema::enableForeignKeyConstraints();
    }
}
