<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_lot_id',
        'slot_number',
        'slot_type',
        'floor',
        'x_coord',
        'y_coord',
        'is_active',
    ];

    public function parkingLot()
    {
        return $this->belongsTo(ParkingLot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if slot is available for a given time window
     */
    public function isAvailable($startTime, $endTime)
    {
        if (!$this->is_active) {
            return false;
        }

        return !$this->bookings()
            ->where('status', 'confirmed')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
            })
            ->exists();
    }
}
