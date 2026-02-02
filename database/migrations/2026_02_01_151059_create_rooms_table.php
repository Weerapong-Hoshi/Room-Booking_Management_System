<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ชื่อห้อง
            $table->integer('capacity'); // ความจุ (คน)
            $table->text('description')->nullable(); // รายละเอียด (ว่างได้)
            $table->string('status')->default('available'); // สถานะห้อง (available, maintenance)
            $table->string('image_url')->nullable(); // URL รูปภาพห้อง (ว่างได้)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
