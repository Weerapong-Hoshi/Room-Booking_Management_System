<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // --- กรณีเป็น ADMIN ---
        if ($user->role === 'admin') {
            // ดึงรายการที่รออนุมัติทั้งหมด
            $pendingBookings = Booking::with(['user', 'room'])
                ->where('status', 'pending')
                ->latest()
                ->get();

            // ดึงรายการห้องทั้งหมด
            $rooms = Room::all();

            return view('admin.dashboard', compact('pendingBookings', 'rooms'));
        }

        // --- กรณีเป็น USER (นักศึกษา/อาจารย์) ---
        $rooms = Room::all()->map(function ($room) use ($user, $now) {

            // ค้นหาการจองที่มีผลอยู่ในปัจจุบัน หรือกำลังจะเกิดขึ้นเร็วๆ นี้ (ที่ได้รับการอนุมัติ หรือ รออนุมัติ)
            $activeBooking = $room->bookings()
                ->whereIn('status', ['approved', 'pending'])
                ->where('end_time', '>=', $now)
                ->with('user')
                ->orderBy('start_time', 'asc')
                ->first();

            if ($activeBooking) {
                $room->booking_id = $activeBooking->id;
                $room->booked_by_name = $activeBooking->user->name;
                $room->booked_by_id = $activeBooking->user->id;
                $room->start_time = $activeBooking->start_time;
                $room->end_time = $activeBooking->end_time;
                $room->booking_status = $activeBooking->status;

                // ตรวจสอบความสัมพันธ์กับ User ปัจจุบัน
                if ($activeBooking->user_id === $user->id) {
                    $room->display_status = 'my_room';
                } elseif ($activeBooking->status === 'approved') {
                    $room->display_status = 'occupied';
                } else {
                    $room->display_status = 'pending_others';
                }
            } else {
                $room->display_status = 'available';
            }

            return $room;
        });

        return view('user.dashboard', compact('rooms'));
    }
}