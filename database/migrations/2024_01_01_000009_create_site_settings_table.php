<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Table already exists — just add missing columns if needed
        Schema::table('site_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('site_settings', 'type')) {
                $table->string('type')->default('text')->after('value');
            }
            if (!Schema::hasColumn('site_settings', 'group')) {
                $table->string('group')->default('general')->after('type');
            }
            if (!Schema::hasColumn('site_settings', 'label')) {
                $table->string('label')->nullable()->after('group');
            }
        });

        // Insert default owner settings (skip if key already exists)
        $defaults = [
            ['key' => 'owner_name',           'value' => 'Chathuranga Dissanayaka',        'type' => 'text',  'group' => 'owner',   'label' => 'Owner Full Name'],
            ['key' => 'owner_title',          'value' => 'Founder & Director',              'type' => 'text',  'group' => 'owner',   'label' => 'Title / Position'],
            ['key' => 'owner_qualification',  'value' => 'B.Sc in Information Technology',  'type' => 'text',  'group' => 'owner',   'label' => 'Education / Qualification'],
            ['key' => 'owner_photo',          'value' => '',                                'type' => 'image', 'group' => 'owner',   'label' => 'Owner Photo'],
            ['key' => 'owner_phone',          'value' => '+94 78 416 1920',                 'type' => 'text',  'group' => 'owner',   'label' => 'Phone Number'],
            ['key' => 'owner_whatsapp',       'value' => '94784161920',                     'type' => 'text',  'group' => 'owner',   'label' => 'WhatsApp Number (no +)'],
            ['key' => 'owner_address',        'value' => 'Kiralabokkagama, Moragollagama',  'type' => 'text',  'group' => 'owner',   'label' => 'Address'],
            ['key' => 'site_name',            'value' => 'WinTech Institute',               'type' => 'text',  'group' => 'general', 'label' => 'Site Name'],
            ['key' => 'site_tagline',         'value' => 'Empowering Future Tech Leaders',  'type' => 'text',  'group' => 'general', 'label' => 'Tagline'],
            ['key' => 'site_email',           'value' => 'info@wintech.lk',                 'type' => 'text',  'group' => 'general', 'label' => 'Contact Email'],
        ];

        foreach ($defaults as $setting) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    public function down(): void
    {
        // Only drop rows we inserted — don't drop the whole table
        $keys = ['owner_name','owner_title','owner_qualification','owner_photo',
                 'owner_phone','owner_whatsapp','owner_address',
                 'site_name','site_tagline','site_email'];
        DB::table('site_settings')->whereIn('key', $keys)->delete();
    }
};