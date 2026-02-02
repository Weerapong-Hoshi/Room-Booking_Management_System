<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. หน้าแรก (ถ้าล็อกอินแล้วไป Dashboard ถ้ายังให้ไป Login)
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('auth.login');
});

// 2. กลุ่ม Route ที่ต้องล็อกอินก่อน (Auth)
Route::middleware(['auth', 'verified'])->group(function () {

    // หน้า Dashboard หลัก (ตัวเดียวจบ เพราะใน Controller เราเขียนแยก Role ไว้แล้ว)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

    // --- ระบบการจอง (Booking System) ---
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/events', [BookingController::class, 'getEvents'])->name('bookings.events');
    Route::get('/bookings/create/{room_id}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // --- ระบบจัดการโปรไฟล์ ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. กลุ่ม Route สำหรับ Admin เท่านั้น
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // จัดการการจอง
    Route::post('/approve/{id}', [AdminController::class, 'approve'])->name('approve');
    Route::post('/reject/{id}', [AdminController::class, 'reject'])->name('reject');

    // จัดการห้อง (Room CRUD)
    Route::get('/rooms', [AdminController::class, 'rooms'])->name('rooms.index'); // ตารางรวม
    Route::get('/rooms/create', [AdminController::class, 'createRoom'])->name('rooms.create'); // หน้าเพิ่ม
    Route::post('/rooms', [AdminController::class, 'storeRoom'])->name('rooms.store'); // บันทึก
    Route::get('/rooms/{room}/edit', [AdminController::class, 'editRoom'])->name('rooms.edit'); // หน้าแก้ไข
    Route::patch('/rooms/{room}', [AdminController::class, 'updateRoom'])->name('rooms.update'); // อัปเดต
    Route::delete('/rooms/{room}', [AdminController::class, 'destroyRoom'])->name('rooms.destroy'); // ลบ

    // จัดการผู้ใช้ (User CRUD)
    Route::resource('users', UserController::class);
});

require __DIR__ . '/auth.php';