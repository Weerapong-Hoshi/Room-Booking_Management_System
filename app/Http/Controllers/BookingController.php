<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    // หน้าปฏิทินรวม
    public function index()
    {
        $rooms = Room::all();
        return view('bookings.index', compact('rooms'));
    }

    // ดึงข้อมูลการจองส่งออกเป็น JSON ให้ปฏิทิน (Google Calendar Style)
    public function getEvents(Request $request)
    {
        $bookings = Booking::with(['user', 'room'])->get();

        $events = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->room->name . ' - ' . $booking->user->name,
                'start' => $booking->start_time,
                'end' => $booking->end_time,
                'color' => $booking->status == 'approved' ? '#10b981' : '#f59e0b', // เขียว=อนุมัติ, ส้ม=รอ
                'extendedProps' => [
                    'room' => $booking->room->name,
                    'user' => $booking->user->name,
                    'status' => $booking->status
                ]
            ];
        });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Logic เช็คการจองซ้ำที่แม่นยำ (Overlapping Period)
        $isConflict = Booking::where('room_id', $request->room_id)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                });
            })->exists();

        if ($isConflict) {
            return back()->withErrors(['msg' => 'ช่วงเวลานี้มีการจองอยู่ก่อนแล้ว กรุณาเช็คจากปฏิทิน']);
        }

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'approved',
        ]);

        return redirect()->route('bookings.index')->with('success', 'จองห้องสำเร็จแล้ว!');
    }
}