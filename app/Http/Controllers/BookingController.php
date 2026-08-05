<?php

namespace App\Http\Controllers;

use App\Models\ParkingLot;
use App\Models\Slot;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Mail\BookingConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Store new parking booking with conflict detection logic.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to your driver account before booking a parking slot.');
        }

        $validated = $request->validate([
            'parking_lot_id' => 'required|exists:parking_lots,id',
            'slot_id' => 'required|exists:slots,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'vehicle_number' => 'required|string|max:30',
            'vehicle_type' => 'required|in:car,suv,bike,ev',
        ]);

        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);

        // Time slot conflict detection in Laravel Eloquent
        $hasConflict = Booking::hasConflict($validated['slot_id'], $startTime, $endTime);

        if ($hasConflict) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Selected parking slot is already booked for the specified time window! Please choose another slot or adjust time.');
        }

        // Fetch parking lot & slot
        $parkingLot = ParkingLot::findOrFail($validated['parking_lot_id']);
        $slot = Slot::findOrFail($validated['slot_id']);

        // Calculate amount
        $hours = max(1, ceil($startTime->diffInMinutes($endTime) / 60));
        $totalAmount = $hours * $parkingLot->price_per_hour;

        // Find or create vehicle record
        $vehicle = Vehicle::firstOrCreate(
            ['vehicle_number' => strtoupper(trim($validated['vehicle_number']))],
            [
                'vehicle_type' => $validated['vehicle_type'],
                'owner_name' => $validated['owner_name'],
                'owner_email' => $validated['owner_email'],
                'owner_phone' => $validated['owner_phone'] ?? null,
            ]
        );

        // Generate unique booking reference
        $bookingReference = 'PK-' . strtoupper(Str::random(6));

        // Create booking
        $booking = Booking::create([
            'booking_reference' => $bookingReference,
            'user_id' => Auth::id(),
            'parking_lot_id' => $parkingLot->id,
            'slot_id' => $slot->id,
            'vehicle_id' => $vehicle->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'total_amount' => $totalAmount,
            'status' => 'confirmed',
        ]);

        // Send email confirmation
        try {
            Mail::to($vehicle->owner_email)->send(new BookingConfirmationMail($booking));
        } catch (\Exception $e) {
            // Log mail failure gracefully if SMTP not configured locally
            \Log::warning('Email sending failed: ' . $e->getMessage());
        }

        return redirect()->route('bookings.confirmation', $booking->booking_reference)
            ->with('success', 'Parking slot reserved successfully!');
    }

    /**
     * Show booking confirmation receipt page.
     */
    public function confirmation($reference)
    {
        $booking = Booking::with(['parkingLot', 'slot', 'vehicle'])
            ->where('booking_reference', $reference)
            ->firstOrFail();

        return view('booking.confirmation', compact('booking'));
    }
}
