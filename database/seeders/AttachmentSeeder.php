<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attachment;
use App\Models\CounselingSession;

class AttachmentSeeder extends Seeder
{
    public function run(): void
    {
        Attachment::truncate();

        $session = CounselingSession::first();

        Attachment::create([
            'session_id' => $session->id,
            'filename' => 'dokumen.pdf',
            'path' => '/uploads/dokumen.pdf',
            'mime_type' => 'application/pdf',
            'size_bytes' => 102400
        ]);
    }
}

