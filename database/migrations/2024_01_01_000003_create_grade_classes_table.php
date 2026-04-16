<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grade_classes', function (Blueprint $table) {
            $table->id();
            $table->string('grade');
            $table->string('subject');
            $table->string('teacher')->nullable();
            $table->text('description')->nullable();
            $table->decimal('monthly_fee', 10, 2)->nullable();
            $table->enum('mode', ['physical', 'online', 'hybrid'])->default('physical');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_class_id')->constrained()->cascadeOnDelete();
            $table->string('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('venue')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
        Schema::dropIfExists('grade_classes');
    }
};