<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grade_classes', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('subject');
            $table->string('thumbnail')->nullable()->after('description');
        });

        // Existing rows වලට slug generate කරනවා
        $rows = DB::table('grade_classes')->get();
        foreach ($rows as $row) {
            $slug = Str::slug($row->grade . '-' . $row->subject);
            // Duplicate avoid කරන්න
            $count = DB::table('grade_classes')
                ->where('slug', $slug)
                ->where('id', '!=', $row->id)
                ->count();
            if ($count > 0) {
                $slug = $slug . '-' . $row->id;
            }
            DB::table('grade_classes')
                ->where('id', $row->id)
                ->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('grade_classes', function (Blueprint $table) {
            $table->dropColumn(['slug', 'thumbnail']);
        });
    }
};