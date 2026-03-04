<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'ห้องเรียน A101',
                'description' => 'ห้องเรียนขนาดใหญ่ รองรับการเรียนการสอน',
                'capacity' => 50,
                'status' => 'available'
            ],
            [
                'name' => 'ห้องเรียน A102',
                'description' => 'ห้องเรียนขนาดกลาง สำหรับกลุ่มย่อย',
                'capacity' => 30,
                'status' => 'available'
            ],
            [
                'name' => 'ห้องประชุม B201',
                'description' => 'ห้องประชุมสำหรับประชุมคณะกรรมการ',
                'capacity' => 20,
                'status' => 'available'
            ],
            [
                'name' => 'ห้องปฏิบัติการ C301',
                'description' => 'ห้องปฏิบัติการคอมพิวเตอร์',
                'capacity' => 25,
                'status' => 'available'
            ],
            [
                'name' => 'ห้องเรียน D401',
                'description' => 'ห้องเรียนสำหรับวิชาเฉพาะทาง',
                'capacity' => 40,
                'status' => 'available'
            ]
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        $this->command->info('Rooms created successfully!');
    }
}