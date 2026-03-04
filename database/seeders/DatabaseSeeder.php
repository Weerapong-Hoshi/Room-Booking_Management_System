<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // เรียกใช้ AdminSeeder ก่อน
        $this->call(AdminSeeder::class);

        // เรียกใช้ Seeder อื่นๆ
        $this->call(RoomSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BookingSeeder::class);
        
        // เรียกใช้ DebugBookingSeeder เพื่อเพิ่มข้อมูลจำลองจำนวนมาก
        $this->call(DebugBookingSeeder::class);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
