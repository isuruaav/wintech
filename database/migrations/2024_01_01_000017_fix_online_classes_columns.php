<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('online_classes', function (Blueprint $table) {
            if (!Schema::hasColumn('online_classes', 'grade_class_id')) {
                $table->foreignId('grade_class_id')
                      ->nullable()
                      ->constrained('grade_classes')
                      ->onDelete('set null')
                      ->after('id');
            }
            if (!Schema::hasColumn('online_classes', 'status')) {
                $table->enum('status', ['upcoming', 'live', 'completed', 'cancelled'])
                      ->default('upcoming')
                      ->after('join_url');
            }
            if (!Schema::hasColumn('online_classes', 'duration_minutes')) {
                $table->integer('duration_minutes')->default(60)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('online_classes', function (Blueprint $table) {
            $table->dropForeign(['grade_class_id']);
            $table->dropColumn(['grade_class_id', 'status', 'duration_minutes']);
        });
    }
};