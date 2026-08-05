<?php

namespace App\Http\Controllers;

use App\Models\ParkingLot;
use App\Models\Slot;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ParkingController extends Controller
{
    /**
     * Display list of parking lots with live availability filter.
     */
    public function index(Request $request)
    {
        $startTimeStr = $request->input('start_time', Carbon::now()->format('Y-m-d\TH:i'));
        $endTimeStr = $request->input('end_time', Carbon::now()->addHours(2)->format('Y-m-d\TH:i'));

        $startTime = Carbon::parse($startTimeStr);
        $endTime = Carbon::parse($endTimeStr);

        // Fetch parking lots with calculated slot availability
        $parkingLots = ParkingLot::withCount(['slots' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        foreach ($parkingLots as $lot) {
            $lot->available_slots = $lot->getAvailableSlotsCount($startTime, $endTime);
        }

        return view('parking.index', compact('parkingLots', 'startTimeStr', 'endTimeStr', 'startTime', 'endTime'));
    }

    /**
     * View interactive HTML5 Canvas parking map & slot selection portal.
     */
    public function show(Request $request, $id)
    {
        $parkingLot = ParkingLot::with(['slots'])->findOrFail($id);

        $startTimeStr = $request->input('start_time', Carbon::now()->format('Y-m-d\TH:i'));
        $endTimeStr = $request->input('end_time', Carbon::now()->addHours(2)->format('Y-m-d\TH:i'));

        $startTime = Carbon::parse($startTimeStr);
        $endTime = Carbon::parse($endTimeStr);

        // Calculate hours and total estimated cost
        $hours = max(1, ceil($startTime->diffInMinutes($endTime) / 60));

        // Get slots with calculated status (available vs booked) for the target time window
        $slots = $parkingLot->slots->map(function ($slot) use ($startTime, $endTime) {
            $isOccupied = Booking::where('slot_id', $slot->id)
                ->where('status', 'confirmed')
                ->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
                })->exists();

            $slot->status = $isOccupied ? 'occupied' : 'available';
            return $slot;
        });

        return view('parking.show', compact('parkingLot', 'slots', 'startTimeStr', 'endTimeStr', 'startTime', 'endTime', 'hours'));
    }
}
