<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // หน้าดูรายการจองทั้งหมดเพื่อกดอนุมัติ
    public function index()
    {
        $bookings = Booking::with(['user', 'room'])->latest()->get();
        return view('admin.bookings', compact('bookings'));
    }

    public function approve($id)
    {
        Booking::findOrFail($id)->update(['status' => 'approved']);
        return back()->with('success', 'อนุมัติการจองเรียบร้อย');
    }

    public function reject($id)
    {
        Booking::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('success', 'ปฏิเสธการจองแล้ว');
    }

    // หน้าจัดการข้อมูลห้อง (CRUD)
    public function rooms()
    {
        $rooms = Room::all();
        return view('admin.rooms', compact('rooms'));
    }
}