<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name'     => 'WinTech Institute of Information Technology',
            'tagline'       => 'Empowering Minds Through Technology',
            'phone'         => '+94 78 416 1920',
            'email'         => 'info@wintech.lk',
            'address'       => 'Kiralabokkagama, Moragollagama',
            'facebook'      => 'https://facebook.com/wintechinstitute',
            'whatsapp'      => '94784161920',
            'total_students'=> '500',
            'total_courses' => '7',
            'years_active'  => '10',
            'total_teachers'=> '15',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}