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

    // 1. หน้าแสดงรายการห้องทั้งหมด (Admin) - ใช้เป็นหน้าหลักสำหรับจัดการห้อง
    public function rooms()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    // 2. หน้าฟอร์มสำหรับเพิ่มห้องใหม่
    public function createRoom()
    {
        return view('admin.rooms.create');
    }

    // 3. บันทึกข้อมูลห้องใหม่
    public function storeRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url', // สำหรับ URL รูปภาพ
            'status' => 'required|in:available,maintenance',
        ]);

        Room::create($request->all());
        return redirect()->route('admin.rooms.index')->with('success', 'เพิ่มห้องใหม่สำเร็จ');
    }

    // 4. หน้าฟอร์มสำหรับแก้ไขห้อง
    public function editRoom(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    // 5. อัปเดตข้อมูลห้อง
    public function updateRoom(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id,
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'status' => 'required|in:available,maintenance',
        ]);

        $room->update($request->all());
        return redirect()->route('admin.rooms.index')->with('success', 'อัปเดตข้อมูลห้องสำเร็จ');
    }

    // 6. ลบห้อง
    public function destroyRoom(Room $room)
    {
        $room->delete();
        return back()->with('success', 'ลบห้องสำเร็จ');
    }
}