<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate ข้อมูล
        $request->validate([
            'room_id' => 'required',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        // 2. เช็คว่าว่างไหม (Logic การซ้อนทับของเวลา)
        $isBooked = Booking::where('room_id', $request->room_id)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    // เคส: เวลาเริ่มที่ขอ อยู่ระหว่างการจองอื่น
                    $q->where('start_time', '>=', $request->start_time)
                        ->where('start_time', '<', $request->end_time);
                })->orWhere(function ($q) use ($request) {
                    // เคส: เวลาจบที่ขอ อยู่ระหว่างการจองอื่น
                    $q->where('start_time', '<', $request->start_time)
                        ->where('end_time', '>', $request->start_time);
                });
            })
            ->exists();

        if ($isBooked) {
            return back()->withErrors(['msg' => 'ห้องนี้ไม่ว่างในช่วงเวลาดังกล่าว']);
        }

        // 3. บันทึกถ้าว่าง
        Booking::create([
            'user_id' => auth()->id(),
            'room_id' => $request->room_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'confirmed', // หรือ pending ถ้าต้องรอแอดมิน
        ]);

        return redirect()->route('dashboard')->with('success', 'จองสำเร็จ');
    }
}
