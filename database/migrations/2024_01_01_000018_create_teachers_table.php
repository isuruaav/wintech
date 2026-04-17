<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subjects')->nullable(); // e.g. "English, ICT"
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // grade_classes ලට teacher_id add කරනවා
        Schema::table('grade_classes', function (Blueprint $table) {
            $table->foreignId('teacher_id')
                  ->nullable()
                  ->constrained('teachers')
                  ->onDelete('set null')
                  ->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('grade_classes', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
        Schema::dropIfExists('teachers');
    }
};