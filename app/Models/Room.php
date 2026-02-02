<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Room extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'description',
        'status',
        'image_url',
    ];

    // ห้องมีการจองหลายรายการ
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // คืนค่า URL เต็มสำหรับรูปภาพ: ถ้าเป็น URL ภายนอกให้ใช้ตรงๆ ถ้าเป็น path ภายใน storage ให้แปลงเป็น asset
    public function getImageUrlAttribute(?string $value)
    {
        if (! $value) {
            return null;
        }

        if (Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        return asset('storage/'.$value);
    }
}
