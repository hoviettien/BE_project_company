<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckJsonKeys extends Command
{
    /**
     * Tên lệnh khi gọi Artisan
     *
     * @var string
     */
    protected $signature = 'check:json-keys';

    /**
     * Mô tả lệnh
     *
     * @var string
     */
    protected $description = 'Kiểm tra và liệt kê tất cả key có trong file articles.json';

    /**
     * Thực thi lệnh
     */
    public function handle()
    {
        $jsonPath = database_path('seeders/data/articles.json');

        if (!File::exists($jsonPath)) {
            $this->error("❌ Không tìm thấy file: $jsonPath");
            return;
        }

        $json = File::get($jsonPath);
        $data = json_decode($json, true);

        if (!$data) {
            $this->error("❌ Không đọc được JSON hoặc file rỗng");
            return;
        }

        $allKeys = [];

        foreach ($data as $index => $item) {
            $keys = array_keys($item);
            $allKeys = array_merge($allKeys, $keys);
            $this->info("👉 Record {$index} có keys: " . implode(", ", $keys));
        }

        $allKeys = array_unique($allKeys);

        $this->line("\n📌 Toàn bộ keys tìm thấy trong JSON:");
        $this->line(implode(", ", $allKeys));
    }
}
