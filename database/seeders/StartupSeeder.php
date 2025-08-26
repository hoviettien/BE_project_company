<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Startup;
use Cloudinary\Api\Upload\UploadApi;

class StartupSeeder extends Seeder
{
    public function run(): void
    {
        
        $json = File::get(database_path('seeders/data/startups.json'));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            $startup = [
                'name' => $item['name'] ?? null,
                'logo' => $item['logo'] ?? null,
                'link' => $item['link'] ?? null,
                'category' => $item['category'] ?? null,
                'category_sub' => $item['category_sub'] ?? null,
                'founder' => $item['founder'] ?? null,
                'location' => $item['location'] ?? null,
            ];

            if (!empty($item['logo'])) {
                try {
                    $uploaded = (new UploadApi())->upload($item['logo'], [
                        'folder' => 'startups'
                    ]);
                    $startup['logo'] = $uploaded['secure_url'];

                    echo "✅ Uploaded: {$startup['name']} → {$startup['logo']}\n";
                } catch (\Exception $e) {
                    echo "⚠️ Upload failed: {$startup['name']} ({$e->getMessage()})\n";
                }
            }

            // Cập nhật hoặc tạo mới
            Startup::updateOrCreate(
                ['name' => $startup['name']],
                $startup
            );
        }


        echo "🎉 Seeder Startup hoàn tất!\n";
    }
}
