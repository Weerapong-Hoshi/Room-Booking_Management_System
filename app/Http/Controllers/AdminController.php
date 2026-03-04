<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // อัปโหลดไฟล์รูปภาพ
            'image_url' => 'nullable|url', // ยังคงรับ URL สำรองได้
            'status' => 'required|in:available,maintenance',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
            $data['image_url'] = $path; // เก็บ path ในคอลัมน์เดิม
        }

        Room::create($data);
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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id,
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
            'status' => 'required|in:available,maintenance',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            // ลบไฟล์เก่าหากเป็นไฟล์ที่เก็บใน storage
            if ($room->image_url && !Str::startsWith($room->image_url, ['http://', 'https://'])) {
                if (Storage::disk('public')->exists($room->image_url)) {
                    Storage::disk('public')->delete($room->image_url);
                }
            }

            $path = $request->file('image')->store('rooms', 'public');
            $data['image_url'] = $path;
        }

        $room->update($data);
        return redirect()->route('admin.rooms.index')->with('success', 'อัปเดตข้อมูลห้องสำเร็จ');
    }

    // 6. ลบห้อง
    public function destroyRoom(Room $room)
    {
        // ลบไฟล์ภาพถ้ามี
        if ($room->image_url && !Str::startsWith($room->image_url, ['http://', 'https://'])) {
            if (Storage::disk('public')->exists($room->image_url)) {
                Storage::disk('public')->delete($room->image_url);
            }
        }

        $room->delete();
        return back()->with('success', 'ลบห้องสำเร็จ');
    }

    /**
     * Display the admin analytics dashboard.
     */
    public function analytics()
    {
        $roomUsageData = Booking::select('room_id')
            ->selectRaw('COUNT(*) as booking_count')
            ->where('status', 'approved')
            ->groupBy('room_id')
            ->with('room')
            ->get();

        $bookingByDate = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('status', 'approved')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // แปลงให้ JS อ่านได้
        $roomLabels = $roomUsageData->map(fn($b) => $b->room->name ?? 'Unknown')->values();
        $roomCounts = $roomUsageData->pluck('booking_count')->values();

        return view('admin.analytics', compact(
            'roomUsageData',
            'bookingByDate',
            'roomLabels',
            'roomCounts'
        ));
    }

    /**
     * Generate PDF report for bookings.
     */
    public function generatePdfReport(Request $request)
    {
        $bookings = Booking::with(['room', 'user'])
            ->where('status', 'approved')
            ->orderBy('start_time', 'desc')
            ->get();

        $html = view('admin.pdf_report', compact('bookings'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'default_font' => 'garuda',  // ฟอนต์ไทย built-in ไม่ต้องลงเพิ่ม!
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('report.pdf', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="room_booking_report_' . now()->format('Y-m-d_H-i-s') . '.pdf"',
        ]);
    }
}