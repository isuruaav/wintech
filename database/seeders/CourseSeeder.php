<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $it  = CourseCategory::where('name', 'IT & Computing')->first()?->id;
        $elec= CourseCategory::where('name', 'Electronics')->first()?->id;
        $net = CourseCategory::where('name', 'Networking')->first()?->id;
        $sec = CourseCategory::where('name', 'Security')->first()?->id;

        $courses = [
            [
                'category_id' => $it,
                'title'       => 'Certificate in Office Applications',
                'description' => 'Master Microsoft Word, Excel, PowerPoint and Outlook. Perfect for beginners entering the workplace.',
                'duration'    => '3 Months',
                'level'       => 'Beginner',
                'fee'         => 4500,
                'is_featured' => true,
                'sort_order'  => 1,
            ],
            [
                'category_id' => $it,
                'title'       => 'Web Development',
                'description' => 'Learn HTML, CSS, JavaScript, PHP and Laravel to build modern websites and web applications.',
                'duration'    => '6 Months',
                'level'       => 'Intermediate',
                'fee'         => 8500,
                'is_featured' => true,
                'sort_order'  => 2,
            ],
            [
                'category_id' => $it,
                'title'       => 'Robo Technology',
                'description' => 'Introduction to robotics, Arduino programming, sensors and automation systems.',
                'duration'    => '4 Months',
                'level'       => 'Intermediate',
                'fee'         => 7500,
                'is_featured' => true,
                'sort_order'  => 3,
            ],
            [
                'category_id' => $elec,
                'title'       => 'Computer Hardware & Networking',
                'description' => 'Hands-on training in PC assembly, troubleshooting, LAN/WAN setup and network administration.',
                'duration'    => '4 Months',
                'level'       => 'Beginner',
                'fee'         => 6500,
                'is_featured' => true,
                'sort_order'  => 4,
            ],
            [
                'category_id' => $elec,
                'title'       => 'Electronics',
                'description' => 'Circuit design, PCB making, electronic components and repair of electronic devices.',
                'duration'    => '5 Months',
                'level'       => 'Intermediate',
                'fee'         => 7000,
                'is_featured' => false,
                'sort_order'  => 5,
            ],
            [
                'category_id' => $sec,
                'title'       => 'CCTV Installation & Maintenance',
                'description' => 'Professional CCTV installation, DVR/NVR setup, IP cameras and surveillance systems.',
                'duration'    => '2 Months',
                'level'       => 'Beginner',
                'fee'         => 5500,
                'is_featured' => false,
                'sort_order'  => 6,
            ],
            [
                'category_id' => $sec,
                'title'       => 'Cyber Security',
                'description' => 'Ethical hacking, network security, penetration testing and cyber threat prevention.',
                'duration'    => '6 Months',
                'level'       => 'Advanced',
                'fee'         => 12000,
                'is_featured' => true,
                'sort_order'  => 7,
            ],
        ];

        foreach ($courses as $course) {
            $course['slug']      = Str::slug($course['title']);
            $course['is_active'] = true;
            Course::updateOrCreate(['slug' => $course['slug']], $course);
        }
    }
}