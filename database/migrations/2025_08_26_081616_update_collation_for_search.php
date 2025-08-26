<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Đổi collation cho cả bảng (tất cả các cột string/text)
        DB::statement("ALTER TABLE speakers CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE startups CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE partners CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE articles CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    }

    public function down(): void
    {
        // Nếu cần rollback thì đưa về utf8mb4_general_ci (hoặc collation cũ)
        DB::statement("ALTER TABLE speakers CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
        DB::statement("ALTER TABLE startups CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
        DB::statement("ALTER TABLE partners CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
        DB::statement("ALTER TABLE articles CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
    }
};

