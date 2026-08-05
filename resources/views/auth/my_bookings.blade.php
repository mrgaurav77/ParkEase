@extends('layouts.app')

@section('title', 'My Parking Bookings - ParkEase')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <span class="badge bg-success bg-opacity-20 text-success px-3 py-2 border border-success border-opacity-30 rounded-pill mb-2">
                <i class="fa-solid fa-id-card me-1"></i> Driver Profile
            </span>
            <h2 class="fw-bold text-white mb-1">My Parking Bookings</h2>
            <p class="text-secondary small mb-0">Welcome back, <strong>{{ $user->name }}</strong> ({{ $user->email }})</p>
        </div>
        <a href="{{ route('parking.index') }}" class="btn btn-park-primary">
            <i class="fa-solid fa-plus me-1"></i> Pre-Book New Slot
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 bg-success bg-opacity-20 text-success rounded-4 p-3 mb-4 d-flex align-items-center">
        <i class="fa-solid fa-circle-check me-3 fs-4"></i>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    <div class="card border-0 p-4" style="background: var(--bg-card); border: 1px solid var(--glass-border) !important; border-radius: 20px;">
        @if($bookings->count() > 0)
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="background: transparent;">
                <thead>
                    <tr class="text-secondary border-bottom border-secondary border-opacity-25 small">
                        <th>BOOKING REF</th>
                        <th>LOCATION & SLOT</th>
                        <th>VEHICLE PLATE</th>
                        <th>RESERVATION TIME</th>
                        <th>FEE TO BE PAID</th>
                        <th>STATUS</th>
                        <th class="text-end">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr class="border-bottom border-secondary border-opacity-10">
                        <td>
                            <span class="font-monospace fw-bold text-emerald" style="color: var(--accent-green);">
                                {{ $booking->booking_reference }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-white">{{ $booking->parkingLot->name }}</div>
                            <small class="text-secondary">Slot {{ $booking->slot->slot_number }} ({{ $booking->slot->floor }})</small>
                        </td>
                        <td>
                            <span class="badge bg-dark border border-secondary text-uppercase fw-bold text-light px-2 py-1">
                                <i class="fa-solid fa-car me-1"></i> {{ $booking->vehicle->vehicle_number }}
                            </span>
                        </td>
                        <td>
                            <small class="text-white d-block">{{ $booking->start_time->format('D, M d, h:i A') }}</small>
                            <small class="text-secondary">to {{ $booking->end_time->format('h:i A') }}</small>
                        </td>
                        <td>
                            <span class="fw-bold text-success">₹{{ number_format($booking->total_amount, 2) }}</span>
                            <small class="text-secondary d-block" style="font-size: 0.75rem;">To be paid at gate</small>
                        </td>
                        <td>
                            <span class="badge bg-success bg-opacity-20 text-success border border-success border-opacity-30">
                                <i class="fa-solid fa-circle-check me-1"></i> {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('bookings.confirmation', $booking->booking_reference) }}" class="btn btn-park-outline btn-sm px-3 py-1">
                                <i class="fa-solid fa-ticket me-1"></i> View Ticket
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa-solid fa-calendar-xmark text-secondary mb-3" style="font-size: 3.5rem;"></i>
            <h5 class="fw-bold text-white mb-2">No Parking Reservations Found</h5>
            <p class="text-secondary small mb-4">You haven't made any parking slot bookings yet.</p>
            <a href="{{ route('parking.index') }}" class="btn btn-park-primary px-4 py-2">
                <i class="fa-solid fa-magnifying-glass me-2"></i> Find & Book Parking Slot
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
