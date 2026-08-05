@extends('layouts.app')

@section('title', 'Booking Receipt - ' . $booking->booking_reference)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <!-- Success Flash Banner -->
            <div class="alert alert-success border-0 bg-success bg-opacity-20 text-success rounded-4 p-3 mb-4 d-flex align-items-center">
                <i class="fa-solid fa-circle-check me-3 fs-3"></i>
                <div>
                    <h6 class="fw-bold mb-0">Booking Reservation Confirmed!</h6>
                    <small>A copy of this parking receipt has been sent to {{ $booking->vehicle->owner_email }}.</small>
                </div>
            </div>

            <!-- Digital Parking Pass Card -->
            <div class="card border-0 p-4 p-md-5" style="background: var(--bg-card); border: 1px solid var(--glass-border) !important; border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
                
                <!-- Ticket Header -->
                <div class="text-center pb-4 mb-4 border-bottom border-secondary border-opacity-25">
                    <span class="badge bg-success bg-opacity-20 text-success px-3 py-2 border border-success border-opacity-30 rounded-pill mb-2">
                        <i class="fa-solid fa-shield-check me-1"></i> Official Smart Parking Pass
                    </span>
                    <h2 class="fw-bold text-white mb-2">ParkEase Entry Pass</h2>
                    <div class="d-inline-block px-4 py-2 rounded-pill font-monospace fw-bold text-emerald" style="background: #0f172a; border: 1px solid var(--accent-green); color: var(--accent-green); font-size: 1.2rem;">
                        {{ $booking->booking_reference }}
                    </div>
                </div>

                <!-- Ticket Grid Details -->
                <div class="row g-4 mb-4">
                    <div class="col-6">
                        <span class="text-secondary small d-block">Location</span>
                        <h6 class="fw-bold text-white mb-0">{{ $booking->parkingLot->name }}</h6>
                        <small class="text-secondary">{{ $booking->parkingLot->location_name }}</small>
                    </div>
                    <div class="col-6 text-end">
                        <span class="text-secondary small d-block">Reserved Slot</span>
                        <h4 class="fw-bold text-success mb-0">Slot {{ $booking->slot->slot_number }}</h4>
                        <small class="text-secondary">{{ $booking->slot->floor }}</small>
                    </div>

                    <div class="col-6">
                        <span class="text-secondary small d-block">Driver Name</span>
                        <h6 class="fw-bold text-white mb-0">{{ $booking->vehicle->owner_name }}</h6>
                        <small class="text-secondary">{{ $booking->vehicle->owner_email }}</small>
                    </div>
                    <div class="col-6 text-end">
                        <span class="text-secondary small d-block">Vehicle Plate</span>
                        <h6 class="fw-bold text-white mb-0 text-uppercase">{{ $booking->vehicle->vehicle_number }}</h6>
                        <small class="text-secondary">{{ strtoupper($booking->vehicle->vehicle_type) }}</small>
                    </div>

                    <div class="col-6">
                        <span class="text-secondary small d-block">Valid From</span>
                        <h6 class="fw-bold text-white mb-0">{{ $booking->start_time->format('D, M d Y') }}</h6>
                        <span class="text-info small">{{ $booking->start_time->format('h:i A') }}</span>
                    </div>
                    <div class="col-6 text-end">
                        <span class="text-secondary small d-block">Valid Until</span>
                        <h6 class="fw-bold text-white mb-0">{{ $booking->end_time->format('D, M d Y') }}</h6>
                        <span class="text-info small">{{ $booking->end_time->format('h:i A') }}</span>
                    </div>
                </div>

                <!-- Amount Box (Updated text & removed QR code) -->
                <div class="p-4 rounded-4 text-center mb-4" style="background: #090d16; border: 1px solid var(--border-color);">
                    <span class="text-secondary small d-block text-uppercase fw-semibold mb-1">Total Parking Fee to be Paid</span>
                    <h1 class="fw-bold text-success mb-1">₹{{ number_format($booking->total_amount, 2) }}</h1>
                    <small class="text-secondary">To be paid at the parking entrance gate upon arrival</small>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3">
                    <button onclick="window.print()" class="btn btn-park-outline w-100 py-2">
                        <i class="fa-solid fa-print me-2"></i> Print Ticket Receipt
                    </button>
                    @auth
                    <a href="{{ route('my.bookings') }}" class="btn btn-park-primary w-100 py-2">
                        <i class="fa-solid fa-ticket me-2"></i> View My Bookings
                    </a>
                    @else
                    <a href="{{ route('parking.index') }}" class="btn btn-park-primary w-100 py-2">
                        <i class="fa-solid fa-house me-2"></i> Return to Hubs
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
