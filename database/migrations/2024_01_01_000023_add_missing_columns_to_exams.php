<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            if (!Schema::hasColumn('exams', 'subject')) {
                $table->string('subject')->nullable();
            }
            if (!Schema::hasColumn('exams', 'grade')) {
                $table->string('grade')->nullable();
            }
            if (!Schema::hasColumn('exams', 'type')) {
                $table->enum('type', ['term_test','mid_year','final','mock','other'])->default('term_test');
            }
            if (!Schema::hasColumn('exams', 'pass_marks')) {
                $table->integer('pass_marks')->default(40);
            }
            if (!Schema::hasColumn('exams', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            foreach (['subject','grade','type','pass_marks','description'] as $col) {
                if (Schema::hasColumn('exams', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};