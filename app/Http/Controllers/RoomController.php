<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RoomController extends Controller
{
    // หน้ารายละเอียดห้อง (สำหรับ User/Guest)
    public function show(Room $room)
    {
        $now = Carbon::now();

        // ดึงการจองที่ยังไม่หมดอายุทั้งหมด (Approved/Pending)
        $activeBookings = $room->bookings()
            ->whereIn('status', ['approved', 'pending'])
            ->where('end_time', '>=', $now)
            ->with('user')
            ->orderBy('start_time')
            ->get();

        // เช็คว่าห้องว่าง "ตอนนี้" หรือมีรายการจองที่ Approved ที่กำลังจะเกิดขึ้น/มีผลอยู่
        $isFullyBooked = $room->bookings()
            ->whereIn('status', ['approved', 'pending'])
            ->where('end_time', '>=', $now) // ถ้าการจองยังไม่หมดเวลา
            ->exists(); // ถ้ามีแม้แต่รายการเดียว ถือว่าไม่ว่างให้จองทันที

        return view('rooms.show', compact('room', 'activeBookings', 'isFullyBooked'));
    }
}