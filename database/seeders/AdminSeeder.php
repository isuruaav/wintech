<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@wintech.lk'],
            [
                'name'      => 'WinTech Admin',
                'email'     => 'admin@wintech.lk',
                'password'  => Hash::make('Admin@12345'),
                'user_type' => 'admin',
                'is_active' => true,
            ]
        );

        // Demo Student
        User::updateOrCreate(
            ['email' => 'student@wintech.lk'],
            [
                'name'         => 'Demo Student',
                'email'        => 'student@wintech.lk',
                'index_number' => 'WIN2024001',
                'phone'        => '0771234567',
                'password'     => Hash::make('Student@12345'),
                'user_type'    => 'student',
                'is_active'    => true,
            ]
        );
    }
}