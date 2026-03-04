<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'นายสมชาย ใจดี',
                'email' => 'somchai@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'นางสาวสุภาพร สวยใส',
                'email' => 'supaporn@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'อาจารย์วิชัย ปัญญาดี',
                'email' => 'wichai@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'นายปกรณ์ พลังใจ',
                'email' => 'pakorn@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'นางสาวจันทร์เพ็ญ งามตา',
                'email' => 'chanpen@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('Users created successfully!');
    }
}