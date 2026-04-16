<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseCategory;

class CourseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'IT & Computing',   'icon' => 'fa-solid fa-computer',       'sort_order' => 1],
            ['name' => 'Electronics',      'icon' => 'fa-solid fa-microchip',       'sort_order' => 2],
            ['name' => 'Networking',       'icon' => 'fa-solid fa-network-wired',   'sort_order' => 3],
            ['name' => 'Security',         'icon' => 'fa-solid fa-shield-halved',   'sort_order' => 4],
        ];

        foreach ($categories as $cat) {
            CourseCategory::updateOrCreate(['name' => $cat['name']], $cat);
        }
    }
}