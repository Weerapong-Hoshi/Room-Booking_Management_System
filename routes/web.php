<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
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
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::post('/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
    // เพิ่ม Route สำหรับจัดการห้องตรงนี้ได้ในอนาคต
});

require __DIR__ . '/auth.php';