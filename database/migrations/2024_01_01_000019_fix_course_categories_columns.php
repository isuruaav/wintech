<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('course_categories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('name');
            }
            if (!Schema::hasColumn('course_categories', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_active');
            }
            if (!Schema::hasColumn('course_categories', 'icon')) {
                $table->string('icon')->nullable()->after('sort_order');
            }
            if (!Schema::hasColumn('course_categories', 'slug')) {
                $table->string('slug')->nullable()->after('icon');
            }
        });

        // Existing rows ලට slug generate කරනවා
        DB::table('course_categories')->get()->each(function ($cat) {
            if (empty($cat->slug)) {
                DB::table('course_categories')
                    ->where('id', $cat->id)
                    ->update(['slug' => \Illuminate\Support\Str::slug($cat->name) . '-' . $cat->id]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('course_categories', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'sort_order', 'icon', 'slug']);
        });
    }
};