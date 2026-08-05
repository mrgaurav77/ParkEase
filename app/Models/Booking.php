<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'user_id',
        'parking_lot_id',
        'slot_id',
        'vehicle_id',
        'start_time',
        'end_time',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parkingLot()
    {
        return $this->belongsTo(ParkingLot::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Check if a slot has overlapping bookings for a specified time window
     */
    public static function hasConflict($slotId, $startTime, $endTime, $ignoreBookingId = null)
    {
        return self::where('slot_id', $slotId)
            ->where('status', 'confirmed')
            ->when($ignoreBookingId, function ($query, $id) {
                return $query->where('id', '!=', $id);
            })
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
            })
            ->exists();
    }
}
