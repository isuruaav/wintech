<?php

namespace Database\Seeders;

use App\Models\GradeClass;
use App\Models\ClassSchedule;
use Illuminate\Database\Seeder;

class GradeClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            // ─────────────── ICT ───────────────
            [
                'grade' => 'Grade 6',  'subject' => 'ICT', 'slug' => 'grade-6-ict',
                'teacher' => 'Mr. Kasun Perera', 'monthly_fee' => 1200, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 1,
                'schedules' => [['day' => 'Saturday', 'start_time' => '08:00', 'end_time' => '09:30']],
            ],
            [
                'grade' => 'Grade 7',  'subject' => 'ICT', 'slug' => 'grade-7-ict',
                'teacher' => 'Mr. Kasun Perera', 'monthly_fee' => 1200, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 2,
                'schedules' => [['day' => 'Saturday', 'start_time' => '09:30', 'end_time' => '11:00']],
            ],
            [
                'grade' => 'Grade 8',  'subject' => 'ICT', 'slug' => 'grade-8-ict',
                'teacher' => 'Mr. Kasun Perera', 'monthly_fee' => 1300, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 3,
                'schedules' => [['day' => 'Saturday', 'start_time' => '11:00', 'end_time' => '12:30']],
            ],
            [
                'grade' => 'Grade 9',  'subject' => 'ICT', 'slug' => 'grade-9-ict',
                'teacher' => 'Mr. Kasun Perera', 'monthly_fee' => 1300, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 4,
                'schedules' => [['day' => 'Sunday', 'start_time' => '08:00', 'end_time' => '09:30']],
            ],
            [
                'grade' => 'Grade 10', 'subject' => 'ICT', 'slug' => 'grade-10-ict',
                'teacher' => 'Mr. Kasun Perera', 'monthly_fee' => 1500, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 5,
                'schedules' => [['day' => 'Sunday', 'start_time' => '09:30', 'end_time' => '11:00']],
            ],
            [
                'grade' => 'Grade 11', 'subject' => 'ICT', 'slug' => 'grade-11-ict',
                'teacher' => 'Mr. Kasun Perera', 'monthly_fee' => 1500, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 6,
                'schedules' => [['day' => 'Sunday', 'start_time' => '11:00', 'end_time' => '12:30']],
            ],
            [
                'grade' => 'O/L',  'subject' => 'ICT', 'slug' => 'ol-ict',
                'teacher' => 'Mr. Kasun Perera', 'monthly_fee' => 2000, 'mode' => 'both', 'medium' => 'both', 'sort_order' => 7,
                'schedules' => [
                    ['day' => 'Saturday', 'start_time' => '14:00', 'end_time' => '16:00'],
                    ['day' => 'Wednesday', 'start_time' => '17:00', 'end_time' => '19:00'],
                ],
            ],
            [
                'grade' => 'A/L',  'subject' => 'ICT', 'slug' => 'al-ict',
                'teacher' => 'Mr. Kasun Perera', 'monthly_fee' => 2500, 'mode' => 'both', 'medium' => 'both', 'sort_order' => 8,
                'schedules' => [
                    ['day' => 'Sunday', 'start_time' => '14:00', 'end_time' => '16:30'],
                    ['day' => 'Thursday', 'start_time' => '17:00', 'end_time' => '19:00'],
                ],
            ],

            // ─────────────── English ───────────────
            [
                'grade' => 'Grade 6',  'subject' => 'English', 'slug' => 'grade-6-english',
                'teacher' => 'Ms. Dilini Fernando', 'monthly_fee' => 1200, 'mode' => 'both', 'medium' => 'english', 'sort_order' => 9,
                'schedules' => [['day' => 'Saturday', 'start_time' => '08:00', 'end_time' => '09:30']],
            ],
            [
                'grade' => 'Grade 7',  'subject' => 'English', 'slug' => 'grade-7-english',
                'teacher' => 'Ms. Dilini Fernando', 'monthly_fee' => 1200, 'mode' => 'both', 'medium' => 'english', 'sort_order' => 10,
                'schedules' => [['day' => 'Saturday', 'start_time' => '09:30', 'end_time' => '11:00']],
            ],
            [
                'grade' => 'Grade 8',  'subject' => 'English', 'slug' => 'grade-8-english',
                'teacher' => 'Ms. Dilini Fernando', 'monthly_fee' => 1200, 'mode' => 'both', 'medium' => 'english', 'sort_order' => 11,
                'schedules' => [['day' => 'Saturday', 'start_time' => '11:00', 'end_time' => '12:30']],
            ],
            [
                'grade' => 'Grade 9',  'subject' => 'English', 'slug' => 'grade-9-english',
                'teacher' => 'Ms. Dilini Fernando', 'monthly_fee' => 1300, 'mode' => 'both', 'medium' => 'english', 'sort_order' => 12,
                'schedules' => [['day' => 'Sunday', 'start_time' => '08:00', 'end_time' => '09:30']],
            ],
            [
                'grade' => 'Grade 10', 'subject' => 'English', 'slug' => 'grade-10-english',
                'teacher' => 'Ms. Dilini Fernando', 'monthly_fee' => 1300, 'mode' => 'both', 'medium' => 'english', 'sort_order' => 13,
                'schedules' => [['day' => 'Sunday', 'start_time' => '09:30', 'end_time' => '11:00']],
            ],
            [
                'grade' => 'Grade 11', 'subject' => 'English', 'slug' => 'grade-11-english',
                'teacher' => 'Ms. Dilini Fernando', 'monthly_fee' => 1300, 'mode' => 'both', 'medium' => 'english', 'sort_order' => 14,
                'schedules' => [['day' => 'Sunday', 'start_time' => '11:00', 'end_time' => '12:30']],
            ],
            [
                'grade' => 'O/L',  'subject' => 'English', 'slug' => 'ol-english',
                'teacher' => 'Ms. Dilini Fernando', 'monthly_fee' => 2000, 'mode' => 'both', 'medium' => 'english', 'sort_order' => 15,
                'schedules' => [
                    ['day' => 'Saturday', 'start_time' => '14:00', 'end_time' => '16:00'],
                    ['day' => 'Tuesday', 'start_time' => '17:00', 'end_time' => '19:00'],
                ],
            ],

            // ─────────────── Mathematics ───────────────
            [
                'grade' => 'Grade 6',  'subject' => 'Mathematics', 'slug' => 'grade-6-mathematics',
                'teacher' => 'Mr. Nuwan Jayasinghe', 'monthly_fee' => 1300, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 16,
                'schedules' => [['day' => 'Saturday', 'start_time' => '08:00', 'end_time' => '09:30']],
            ],
            [
                'grade' => 'Grade 7',  'subject' => 'Mathematics', 'slug' => 'grade-7-mathematics',
                'teacher' => 'Mr. Nuwan Jayasinghe', 'monthly_fee' => 1300, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 17,
                'schedules' => [['day' => 'Saturday', 'start_time' => '09:30', 'end_time' => '11:00']],
            ],
            [
                'grade' => 'Grade 8',  'subject' => 'Mathematics', 'slug' => 'grade-8-mathematics',
                'teacher' => 'Mr. Nuwan Jayasinghe', 'monthly_fee' => 1300, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 18,
                'schedules' => [['day' => 'Saturday', 'start_time' => '11:00', 'end_time' => '12:30']],
            ],
            [
                'grade' => 'Grade 9',  'subject' => 'Mathematics', 'slug' => 'grade-9-mathematics',
                'teacher' => 'Mr. Nuwan Jayasinghe', 'monthly_fee' => 1400, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 19,
                'schedules' => [['day' => 'Sunday', 'start_time' => '08:00', 'end_time' => '09:30']],
            ],
            [
                'grade' => 'Grade 10', 'subject' => 'Mathematics', 'slug' => 'grade-10-mathematics',
                'teacher' => 'Mr. Nuwan Jayasinghe', 'monthly_fee' => 1500, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 20,
                'schedules' => [['day' => 'Sunday', 'start_time' => '09:30', 'end_time' => '11:00']],
            ],
            [
                'grade' => 'Grade 11', 'subject' => 'Mathematics', 'slug' => 'grade-11-mathematics',
                'teacher' => 'Mr. Nuwan Jayasinghe', 'monthly_fee' => 1500, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 21,
                'schedules' => [['day' => 'Sunday', 'start_time' => '11:00', 'end_time' => '12:30']],
            ],
            [
                'grade' => 'O/L',  'subject' => 'Mathematics', 'slug' => 'ol-mathematics',
                'teacher' => 'Mr. Nuwan Jayasinghe', 'monthly_fee' => 2200, 'mode' => 'both', 'medium' => 'both', 'sort_order' => 22,
                'schedules' => [
                    ['day' => 'Saturday', 'start_time' => '14:00', 'end_time' => '16:30'],
                    ['day' => 'Wednesday', 'start_time' => '17:00', 'end_time' => '19:00'],
                ],
            ],
            [
                'grade' => 'A/L',  'subject' => 'Mathematics', 'slug' => 'al-mathematics',
                'teacher' => 'Mr. Nuwan Jayasinghe', 'monthly_fee' => 2800, 'mode' => 'both', 'medium' => 'both', 'sort_order' => 23,
                'schedules' => [
                    ['day' => 'Sunday', 'start_time' => '14:00', 'end_time' => '16:30'],
                    ['day' => 'Friday', 'start_time' => '17:00', 'end_time' => '19:00'],
                ],
            ],

            // ─────────────── Science ───────────────
            [
                'grade' => 'Grade 6',  'subject' => 'Science', 'slug' => 'grade-6-science',
                'teacher' => 'Ms. Chamari Silva', 'monthly_fee' => 1200, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 24,
                'schedules' => [['day' => 'Saturday', 'start_time' => '08:00', 'end_time' => '09:30']],
            ],
            [
                'grade' => 'Grade 7',  'subject' => 'Science', 'slug' => 'grade-7-science',
                'teacher' => 'Ms. Chamari Silva', 'monthly_fee' => 1200, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 25,
                'schedules' => [['day' => 'Saturday', 'start_time' => '09:30', 'end_time' => '11:00']],
            ],
            [
                'grade' => 'Grade 8',  'subject' => 'Science', 'slug' => 'grade-8-science',
                'teacher' => 'Ms. Chamari Silva', 'monthly_fee' => 1200, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 26,
                'schedules' => [['day' => 'Saturday', 'start_time' => '11:00', 'end_time' => '12:30']],
            ],
            [
                'grade' => 'Grade 9',  'subject' => 'Science', 'slug' => 'grade-9-science',
                'teacher' => 'Ms. Chamari Silva', 'monthly_fee' => 1300, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 27,
                'schedules' => [['day' => 'Sunday', 'start_time' => '08:00', 'end_time' => '09:30']],
            ],
            [
                'grade' => 'Grade 10', 'subject' => 'Science', 'slug' => 'grade-10-science',
                'teacher' => 'Ms. Chamari Silva', 'monthly_fee' => 1400, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 28,
                'schedules' => [['day' => 'Sunday', 'start_time' => '09:30', 'end_time' => '11:00']],
            ],
            [
                'grade' => 'Grade 11', 'subject' => 'Science', 'slug' => 'grade-11-science',
                'teacher' => 'Ms. Chamari Silva', 'monthly_fee' => 1500, 'mode' => 'both', 'medium' => 'sinhala', 'sort_order' => 29,
                'schedules' => [['day' => 'Sunday', 'start_time' => '11:00', 'end_time' => '12:30']],
            ],
            [
                'grade' => 'O/L',  'subject' => 'Science', 'slug' => 'ol-science',
                'teacher' => 'Ms. Chamari Silva', 'monthly_fee' => 2000, 'mode' => 'both', 'medium' => 'both', 'sort_order' => 30,
                'schedules' => [
                    ['day' => 'Saturday', 'start_time' => '14:00', 'end_time' => '16:00'],
                    ['day' => 'Thursday', 'start_time' => '17:00', 'end_time' => '19:00'],
                ],
            ],
        ];

        foreach ($classes as $classData) {
            $schedules = $classData['schedules'] ?? [];
            unset($classData['schedules']);

            $gradeClass = GradeClass::firstOrCreate(
                ['slug' => $classData['slug']],
                array_merge($classData, ['is_active' => true])
            );

            if ($gradeClass->schedules()->count() === 0) {
                foreach ($schedules as $schedule) {
                    $gradeClass->schedules()->create(array_merge($schedule, ['is_active' => true]));
                }
            }
        }
    }
}