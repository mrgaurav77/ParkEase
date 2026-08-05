<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_number',
        'vehicle_type',
        'owner_name',
        'owner_email',
        'owner_phone',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
