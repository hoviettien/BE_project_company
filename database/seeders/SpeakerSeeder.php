<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Speaker;
use Cloudinary\Api\Upload\UploadApi;

class SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/giamkhaonew_cleaned_final.json'));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            $speaker = [
                'name' => $item['name'] ?? null,
                'title' => $item['title'] ?? null,
                'role' => $item['role'] ?? null,
                'organization' => $item['organization'] ?? null,
                'detail' => $item['detail'] ?? null,
                'event' => $item['event'] ?? null,
                'image_url' => $item['image_url'] ?? null,
            ];

            if (!empty($item['image_url'])) {
                try {
                    $uploaded = (new UploadApi())->upload($item['image_url'], [
                        'folder' => 'speakers'
                    ]);
                    $speaker['image_url'] = $uploaded['secure_url'];

                    echo "✅ Uploaded: {$speaker['name']} → {$speaker['image_url']}\n";
                } catch (\Exception $e) {
                    echo "⚠️ Upload failed: {$speaker['name']} ({$e->getMessage()})\n";
                }

            }

            Speaker::create($speaker);
        }

        echo "🎉 Seeder hoàn tất!\n";
    }
}
