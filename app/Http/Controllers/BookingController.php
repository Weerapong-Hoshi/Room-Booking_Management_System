<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    // 1. หน้าปฏิทินรวม (แสดง FullCalendar)
    public function index()
    {
        $rooms = Room::all();
        return view('bookings.index', compact('rooms'));
    }

    // 2. ส่งข้อมูลการจองเป็น JSON ให้ปฏิทิน
    public function getEvents(Request $request)
    {
        $bookings = Booking::with(['user', 'room'])->get();

        $events = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->room->name . ' - ' . $booking->user->name,
                'start' => $booking->start_time,
                'end' => $booking->end_time,
                'color' => '#10b981', // สีเขียว
            ];
        });

        return response()->json($events);
    }

    // 3. ฟังก์ชันที่ขาดไป: หน้าฟอร์มกรอกข้อมูลการจอง
    public function create($room_id)
    {
        $room = Room::findOrFail($room_id);
        return view('bookings.create', compact('room'));
    }

    // 4. บันทึกข้อมูลการจอง (พร้อม Logic เช็คเวลาซ้ำ)
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        // เช็คว่าห้องว่างไหมในช่วงเวลาที่เลือก
        $isConflict = Booking::where('room_id', $request->room_id)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                });
            })->exists();

        if ($isConflict) {
            return back()->withErrors(['msg' => 'ไม่สามารถจองได้ เนื่องจากช่วงเวลานี้มีคนจองห้องนี้ไปแล้ว']);
        }
        // บันทึกข้อมูล
        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'จองห้องสำเร็จเรียบร้อยแล้ว!');
    }
    public function cancel($id)
    {
        $booking = Booking::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $booking->delete();

        return back()->with('success', 'ยกเลิกการจองเรียบร้อยแล้ว');
    }

}