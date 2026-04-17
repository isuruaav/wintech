<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            if (!Schema::hasColumn('videos', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('grade_class_id');
            }
            if (!Schema::hasColumn('videos', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('is_featured');
            }
            if (!Schema::hasColumn('videos', 'platform')) {
                $table->string('platform')->default('youtube')->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'is_active', 'platform']);
        });
    }
};