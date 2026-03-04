<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ดึงข้อมูลห้องและผู้ใช้ที่มีอยู่
        $rooms = \App\Models\Room::all();
        $users = \App\Models\User::where('role', 'user')->get();
        
        if ($rooms->isEmpty() || $users->isEmpty()) {
            $this->command->error('Please run RoomSeeder and UserSeeder first!');
            return;
        }

        $bookings = [];

        // สร้างการจองหลายรายการเพื่อให้เห็นข้อมูลใน Chart
        $now = Carbon::now();
        
        // สร้างการจองสำหรับ 7 วันที่ผ่านมา
        for ($i = 0; $i < 7; $i++) {
            $date = $now->copy()->subDays($i);
            
            // สร้างการจอง 2-3 รายการต่อวัน
            $bookingCount = rand(2, 3);
            
            for ($j = 0; $j < $bookingCount; $j++) {
                $room = $rooms->random();
                $user = $users->random();
                
                // สุ่มช่วงเวลาการจอง
                $startHour = rand(8, 16);
                $duration = rand(1, 3); // 1-3 ชั่วโมง
                
                $startTime = $date->copy()->setHour($startHour)->setMinute(0)->setSecond(0);
                $endTime = $startTime->copy()->addHours($duration);
                
                // สุ่มสถานะการจอง (ส่วนใหญ่เป็น approved)
                $status = rand(1, 10) <= 8 ? 'approved' : 'pending';

                $bookings[] = [
                    'room_id' => $room->id,
                    'user_id' => $user->id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'status' => $status,
                    'created_at' => $startTime->copy()->subHours(rand(1, 24)),
                    'updated_at' => now(),
                ];
            }
        }

        // เพิ่มการจองบางรายการที่มีการจองห้องเดียวกันหลายครั้ง (เพื่อให้เห็นห้องที่ใช้งานมากที่สุด)
        $popularRoom = $rooms->first();
        $popularUser = $users->first();
        
        for ($i = 0; $i < 5; $i++) {
            $date = $now->copy()->subDays(rand(1, 5));
            $startHour = rand(9, 15);
            
            $startTime = $date->copy()->setHour($startHour)->setMinute(0)->setSecond(0);
            $endTime = $startTime->copy()->addHours(rand(1, 2));
            
            $bookings[] = [
                'room_id' => $popularRoom->id,
                'user_id' => $popularUser->id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => 'approved',
                'created_at' => $startTime->copy()->subHours(rand(1, 12)),
                'updated_at' => now(),
            ];
        }

        // บันทึกการจองทั้งหมด
        foreach ($bookings as $booking) {
            Booking::create($booking);
        }

        $this->command->info('Bookings created successfully!');
        $this->command->info('Total bookings: ' . count($bookings));
    }
}