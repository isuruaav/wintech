<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `grade_classes` MODIFY `mode` ENUM('physical', 'online', 'both') NOT NULL DEFAULT 'both'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `grade_classes` MODIFY `mode` ENUM('physical', 'online') NOT NULL DEFAULT 'physical'");
    }
};