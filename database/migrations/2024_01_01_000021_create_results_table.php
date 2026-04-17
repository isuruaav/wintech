<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('results', function (Blueprint $table) {

            if (!Schema::hasColumn('results', 'user_id')) {
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('results', 'exam_id')) {
                $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('results', 'marks')) {
                $table->decimal('marks', 6, 2)->default(0);
            }
            if (!Schema::hasColumn('results', 'grade_letter')) {
                $table->string('grade_letter')->nullable();
            }
            if (!Schema::hasColumn('results', 'status')) {
                $table->enum('status', ['pass', 'fail'])->default('fail');
            }
            if (!Schema::hasColumn('results', 'remarks')) {
                $table->text('remarks')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            $cols = ['marks', 'grade_letter', 'status', 'remarks'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('results', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};