<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('results', function (Blueprint $table) {
            // student_id nullable කරන්න
            if (Schema::hasColumn('results', 'student_id')) {
                $table->unsignedBigInteger('student_id')->nullable()->change();
            }
            // marks_obtained nullable කරන්න (old column)
            if (Schema::hasColumn('results', 'marks_obtained')) {
                $table->decimal('marks_obtained', 6, 2)->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            if (Schema::hasColumn('results', 'student_id')) {
                $table->unsignedBigInteger('student_id')->nullable(false)->change();
            }
        });
    }
};