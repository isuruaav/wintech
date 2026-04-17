<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            if (!Schema::hasColumn('videos', 'grade_class_id')) {
                $table->foreignId('grade_class_id')
                      ->nullable()
                      ->constrained('grade_classes')
                      ->onDelete('set null')
                      ->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['grade_class_id']);
            $table->dropColumn('grade_class_id');
        });
    }
};