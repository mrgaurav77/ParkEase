<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location_name',
        'address',
        'total_slots',
        'price_per_hour',
        'latitude',
        'longitude',
        'image_url',
    ];

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getAvailableSlotsCount($startTime = null, $endTime = null)
    {
        if (!$startTime || !$endTime) {
            $startTime = now();
            $endTime = now()->addHours(2);
        }

        return $this->slots()
            ->where('is_active', true)
            ->whereDoesntHave('bookings', function ($query) use ($startTime, $endTime) {
                $query->where('status', 'confirmed')
                    ->where(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<', $endTime)
                          ->where('end_time', '>', $startTime);
                    });
            })
            ->count();
    }
}
