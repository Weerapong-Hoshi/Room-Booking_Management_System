<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Models\Room;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// หน้าแรกสุด (Welcome Page)
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login'); // ให้หน้าแรกเป็นหน้า Login ไปเลย
});

// หน้า Dashboard (ปรับให้แยกตามบทบาทผู้ใช้)
Route::get('/dashboard', function () {
    $user = auth()->user();

    // ถ้าเป็น Admin ให้ไปหน้าจัดการ
    if ($user->role === 'admin') {
        $bookings = \App\Models\Booking::with(['user', 'room'])->latest()->get();
        $rooms = \App\Models\Room::all();
        return view('admin.dashboard', compact('bookings', 'rooms'));
    }

    // ถ้าเป็น User ทั่วไป ให้เห็นหน้าจองห้อง (โค้ดเดิม)
    $rooms = Room::all()->map(function ($room) {
        $now = now();
        $room->is_busy = $room->bookings()
            ->where('status', 'approved')
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->exists();

        $room->has_pending = $room->bookings()->where('status', 'pending')->exists();
        return $room;
    });

    return view('dashboard', compact('rooms'));

})->middleware(['auth'])->name('dashboard');

/**
 * รวมกลุ่ม Route ที่ต้อง Login ก่อนถึงจะเข้าได้ (Middleware: auth)
 */
Route::middleware(['auth', 'verified'])->group(function () {

    // --- หน้า Dashboard (แสดงรายการห้องพร้อมสถานะ Real-time) ---
    Route::get('/dashboard', function () {
        $rooms = Room::all()->map(function ($room) {
            // เช็คว่า ณ เวลาปัจจุบัน (now()) ห้องนี้มีการจองที่ได้รับการอนุมัติหรือไม่
            $room->is_busy = $room->bookings()
                // ->where('status', 'approved') // เปิดใช้ถ้าคุณมีระบบแอดมินกดอนุมัติ
                ->where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->exists();
            return $room;
        });

        return view('dashboard', compact('rooms'));
    })->name('dashboard');

    // --- ระบบการจอง (Booking System) ---

    // 1. หน้าแสดงปฏิทินรวม (Google Calendar Style)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

    // 2. ดึงข้อมูลการจองเป็น JSON (สำหรับส่งให้ FullCalendar)
    Route::get('/bookings/events', [BookingController::class, 'getEvents'])->name('bookings.events');

    // 3. หน้าฟอร์มจองห้อง (กดมาจาก Dashboard)
    Route::get('/bookings/create/{room_id}', [BookingController::class, 'create'])->name('bookings.create');

    // 4. บันทึกการจองลงฐานข้อมูล
    Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');


    // --- ระบบจัดการโปรไฟล์ (มากับ Laravel Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * ตัวอย่าง Route สำหรับ Admin (ในอนาคต)
 * คุณสามารถสร้าง Middleware 'admin' มาครอบส่วนนี้ได้
 */
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // Route::get('/admin/rooms', [RoomController::class, 'index'])->name('admin.rooms');
});

// ระบบ Admin
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/bookings', [AdminController::class, 'index'])->name('admin.bookings');
    Route::post('/bookings/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/bookings/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');
    Route::get('/rooms', [AdminController::class, 'rooms'])->name('admin.rooms');
});

// ดึงไฟล์ Route สำหรับระบบ Login/Register มาทำงาน (ของ Breeze)
require __DIR__ . '/auth.php';