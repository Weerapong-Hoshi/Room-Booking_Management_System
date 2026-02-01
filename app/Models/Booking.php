<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'start_time',
        'end_time',
        'status',
    ];

    // จองโดย User คนไหน
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // จอง Room ห้องไหน
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
