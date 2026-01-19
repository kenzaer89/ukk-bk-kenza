<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CounselingSession;
use App\Models\Topic;

class SessionTopicSeeder extends Seeder
{
    public function run(): void
    {
        \DB::table('session_topic')->truncate();

        $session = CounselingSession::first();
        $topics = Topic::all();

        if ($session) {
            foreach($topics as $topic){
                $session->topics()->attach($topic->id);
            }
        }
    }
}
