<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        // Đọc file JSON
        $json = File::get(database_path('seeders/data/partners.json'));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            Partner::create([
                'id' => $item['id'] ?? null,
                'name' => $item['name'] ?? null,
                'logo' => $item['logo'] ?? null,
                'category' => $item['category'] ?? null,
                'url' => $item['url'] ?? null,
                'description' => $item['description'] ?? null,
                'website' => $item['website'] ?? null,
                'event' => $item['event'] ?? null,
            ]);

            echo "✅ Added partner: {$item['name']}\n";
        }

        echo "🎉 Seeder Partner hoàn tất!\n";
    }
}
