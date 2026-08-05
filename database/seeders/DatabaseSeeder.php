<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ParkingLot;
use App\Models\Slot;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with Nashik City Locations & Default Driver User.
     */
    public function run(): void
    {
        // Clear existing tables
        Booking::query()->delete();
        Vehicle::query()->delete();
        Slot::query()->delete();
        ParkingLot::query()->delete();
        User::query()->delete();

        // Sample Demo User
        $user = User::create([
            'name' => 'Rahul Sharma',
            'email' => 'driver@nashik.com',
            'password' => Hash::make('password123'),
        ]);

        // Location 1: CBS Central Parking Hub (Nashik)
        $lot1 = ParkingLot::create([
            'name' => 'CBS Central Parking Hub',
            'location_name' => 'Old CBS, Shivaji Road, Nashik',
            'address' => 'Opposite District Court, Shivaji Road, Nashik - 422001',
            'total_slots' => 16,
            'price_per_hour' => 30.00,
            'latitude' => 19.9975,
            'longitude' => 73.7898,
            'image_url' => 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?auto=format&fit=crop&w=800&q=80',
        ]);

        for ($i = 1; $i <= 8; $i++) {
            Slot::create([
                'parking_lot_id' => $lot1->id,
                'slot_number' => 'A' . $i,
                'slot_type' => ($i <= 2) ? 'handicap' : 'regular',
                'floor' => 'Level 1',
                'x_coord' => 40 + ($i - 1) * 80,
                'y_coord' => 60,
                'is_active' => true,
            ]);
        }
        for ($i = 1; $i <= 8; $i++) {
            Slot::create([
                'parking_lot_id' => $lot1->id,
                'slot_number' => 'B' . $i,
                'slot_type' => ($i >= 7) ? 'ev' : 'regular',
                'floor' => 'Level 1',
                'x_coord' => 40 + ($i - 1) * 80,
                'y_coord' => 200,
                'is_active' => true,
            ]);
        }

        // Location 2: College Road City Center Deck (Nashik)
        $lot2 = ParkingLot::create([
            'name' => 'College Road Plaza Parking',
            'location_name' => 'College Road, Nashik',
            'address' => 'Near BYK College, College Road, Nashik - 422005',
            'total_slots' => 16,
            'price_per_hour' => 40.00,
            'latitude' => 20.0050,
            'longitude' => 73.7650,
            'image_url' => 'https://images.unsplash.com/photo-1573348722427-f1d6819fdf98?auto=format&fit=crop&w=800&q=80',
        ]);

        for ($i = 1; $i <= 8; $i++) {
            Slot::create([
                'parking_lot_id' => $lot2->id,
                'slot_number' => 'E' . $i,
                'slot_type' => ($i <= 4) ? 'ev' : 'regular',
                'floor' => 'Ground Floor',
                'x_coord' => 40 + ($i - 1) * 80,
                'y_coord' => 60,
                'is_active' => true,
            ]);
        }
        for ($i = 1; $i <= 8; $i++) {
            Slot::create([
                'parking_lot_id' => $lot2->id,
                'slot_number' => 'C' . $i,
                'slot_type' => ($i == 8) ? 'handicap' : 'compact',
                'floor' => 'Ground Floor',
                'x_coord' => 40 + ($i - 1) * 80,
                'y_coord' => 200,
                'is_active' => true,
            ]);
        }

        // Location 3: Panchavati Ghat Parking Plaza (Nashik)
        $lot3 = ParkingLot::create([
            'name' => 'Panchavati Smart Parking Plaza',
            'location_name' => 'Panchavati, Near Ramkund, Nashik',
            'address' => 'Near Sita Gufa Road, Panchavati, Nashik - 422003',
            'total_slots' => 16,
            'price_per_hour' => 25.00,
            'latitude' => 20.0080,
            'longitude' => 73.7940,
            'image_url' => 'https://images.unsplash.com/photo-1590674899484-d5640e854abe?auto=format&fit=crop&w=800&q=80',
        ]);

        for ($i = 1; $i <= 8; $i++) {
            Slot::create([
                'parking_lot_id' => $lot3->id,
                'slot_number' => 'M' . $i,
                'slot_type' => 'regular',
                'floor' => 'P1 East',
                'x_coord' => 40 + ($i - 1) * 80,
                'y_coord' => 60,
                'is_active' => true,
            ]);
        }
        for ($i = 1; $i <= 8; $i++) {
            Slot::create([
                'parking_lot_id' => $lot3->id,
                'slot_number' => 'N' . $i,
                'slot_type' => ($i <= 3) ? 'ev' : 'compact',
                'floor' => 'P1 West',
                'x_coord' => 40 + ($i - 1) * 80,
                'y_coord' => 200,
                'is_active' => true,
            ]);
        }

        // Sample vehicles
        $v1 = Vehicle::create([
            'vehicle_number' => 'MH-15-AB-1234',
            'vehicle_type' => 'car',
            'owner_name' => 'Rahul Sharma',
            'owner_email' => 'driver@nashik.com',
            'owner_phone' => '+919822012345',
        ]);

        $v2 = Vehicle::create([
            'vehicle_number' => 'MH-15-EV-5678',
            'vehicle_type' => 'ev',
            'owner_name' => 'Priya Patil',
            'owner_email' => 'priya@example.com',
            'owner_phone' => '+919822098765',
        ]);

        // Sample active bookings
        $slotA3 = Slot::where('slot_number', 'A3')->first();
        Booking::create([
            'booking_reference' => 'PK-' . strtoupper(Str::random(6)),
            'user_id' => $user->id,
            'parking_lot_id' => $lot1->id,
            'slot_id' => $slotA3->id,
            'vehicle_id' => $v1->id,
            'start_time' => Carbon::now()->subMinutes(30),
            'end_time' => Carbon::now()->addHours(2),
            'total_amount' => 60.00,
            'status' => 'confirmed',
        ]);

        $slotE1 = Slot::where('slot_number', 'E1')->first();
        Booking::create([
            'booking_reference' => 'PK-' . strtoupper(Str::random(6)),
            'parking_lot_id' => $lot2->id,
            'slot_id' => $slotE1->id,
            'vehicle_id' => $v2->id,
            'start_time' => Carbon::now()->subMinutes(10),
            'end_time' => Carbon::now()->addHours(3),
            'total_amount' => 120.00,
            'status' => 'confirmed',
        ]);
    }
}
