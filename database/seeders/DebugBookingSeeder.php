<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;

class DebugBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // สร้างห้องเพิ่มเติมถ้ายังไม่มี
        if (Room::count() < 5) {
            Room::factory()->count(5)->create();
        }

        // สร้างผู้ใช้เพิ่มเติมถ้ายังไม่มี
        if (User::count() < 10) {
            User::factory()->count(10)->create();
        }

        // ลบข้อมูลการจองเดิมทั้งหมด
        Booking::truncate();

        // สร้างข้อมูลการจองจำนวนมากในช่วง 30 วันล่าสุด
        $rooms = Room::all();
        $users = User::all();
        $statuses = ['approved', 'pending', 'rejected'];
        
        // สร้างการจองย้อนหลัง 30 วัน
        for ($daysAgo = 0; $daysAgo < 30; $daysAgo++) {
            $date = now()->subDays($daysAgo);
            
            // สร้างการจองหลายครั้งต่อวัน
            $bookingsPerDay = rand(5, 15);
            
            for ($i = 0; $i < $bookingsPerDay; $i++) {
                $startTime = $date->copy()->addHours(rand(8, 18))->addMinutes(rand(0, 59));
                $endTime = $startTime->copy()->addHours(rand(1, 3));
                
                Booking::create([
                    'user_id' => $users->random()->id,
                    'room_id' => $rooms->random()->id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }

        // สร้างการจองเพิ่มเติมในอนาคต
        for ($daysFuture = 1; $daysFuture <= 10; $daysFuture++) {
            $date = now()->addDays($daysFuture);
            
            $bookingsPerDay = rand(3, 8);
            
            for ($i = 0; $i < $bookingsPerDay; $i++) {
                $startTime = $date->copy()->addHours(rand(8, 18))->addMinutes(rand(0, 59));
                $endTime = $startTime->copy()->addHours(rand(1, 3));
                
                Booking::create([
                    'user_id' => $users->random()->id,
                    'room_id' => $rooms->random()->id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }

        echo "✅ สร้างข้อมูลการจองสำเร็จ: " . Booking::count() . " รายการ\n";
        echo "✅ ห้องทั้งหมด: " . Room::count() . " ห้อง\n";
        echo "✅ ผู้ใช้ทั้งหมด: " . User::count() . " คน\n";
    }
}