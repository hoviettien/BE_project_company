<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Đọc file JSON
        $json = File::get(database_path('seeders/data/articles.json'));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            $article = [
                'title' => $item['title'] ?? null,
                'description' => $item['content'] ?? null,
                'url' => $item['link'] ?? null,
                'published_at' => $item['date'] ?? null,
                'category' => $item['category'] ?? null,
                'event' => $item['event'] ?? null,
                'image' => $item['image'] ?? null, // thêm link Cloudinary ở đây
                'images' => isset($item['images']) ? json_encode($item['images']) : null,
            ];
            Article::create($article);



            echo "✅ Added article: {$article['title']}\n";
        }

        echo "🎉 Seeder Article hoàn tất!\n";
    }
}
