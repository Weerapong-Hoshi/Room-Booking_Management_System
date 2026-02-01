<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // เชื่อมกับ Users
            $table->foreignId('room_id')->constrained()->onDelete('cascade'); // เชื่อมกับ Rooms
            $table->dateTime('start_time'); // เวลาเริ่ม
            $table->dateTime('end_time');   // เวลาจบ
            $table->string('status')->default('pending'); // pending(รออนุมัติ), approved(อนุมัติ), rejected(ปฏิเสธ)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
