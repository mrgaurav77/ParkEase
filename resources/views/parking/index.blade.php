@extends('layouts.app')

@section('title', 'Nashik City Parking - ParkEase')

@section('content')
<!-- Hero Section -->
<section class="hero-banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-success bg-opacity-20 text-success mb-3 px-3 py-2 border border-success border-opacity-30 rounded-pill">
                    <i class="fa-solid fa-satellite-dish me-1"></i> Live Real-Time Slot Telemetry
                </span>
                <h1 class="display-5 fw-bold text-white mb-3">
                    Nashik City Parking Finder & Pre-Booking System
                </h1>
                <p class="lead text-secondary mb-4">
                    Locate available parking bays across key hubs in Nashik city, view real-time slot layout, avoid peak traffic delays, and pre-book your parking spot in seconds.
                </p>
            </div>
            
            <!-- Quick Filter Bar -->
            <div class="col-lg-12 mt-3">
                <div class="card border-0 p-4" style="background: var(--bg-card); border: 1px solid var(--glass-border) !important; border-radius: 20px;">
                    <form action="{{ route('parking.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label text-secondary fw-semibold small">
                                <i class="fa-regular fa-clock me-1 text-success"></i> Reservation Start Time
                            </label>
                            <input type="datetime-local" name="start_time" class="form-control bg-dark text-white border-secondary" value="{{ $startTimeStr }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary fw-semibold small">
                                <i class="fa-regular fa-clock me-1 text-danger"></i> Reservation End Time
                            </label>
                            <input type="datetime-local" name="end_time" class="form-control bg-dark text-white border-secondary" value="{{ $endTimeStr }}">
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-park-primary w-100 py-2 fw-bold">
                                <i class="fa-solid fa-magnifying-glass me-2"></i> Update Availability
                            </button>
                            <a href="{{ route('parking.index') }}" class="btn btn-park-outline px-3" title="Reset Filters">
                                <i class="fa-solid fa-rotate-right"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Parking Lots Grid -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1"><i class="fa-solid fa-location-dot text-success me-2"></i>Nashik Smart Parking Hubs</h3>
                <p class="text-secondary small mb-0">Target window: {{ $startTime->format('M d, H:i') }} &mdash; {{ $endTime->format('M d, H:i') }} ({{ max(1, ceil($startTime->diffInMinutes($endTime) / 60)) }} hrs)</p>
            </div>
            <span class="badge bg-dark border border-secondary px-3 py-2 text-secondary">
                <i class="fa-solid fa-layer-group text-primary me-1"></i> {{ $parkingLots->count() }} Locations Available
            </span>
        </div>

        <div class="row g-4">
            @foreach($parkingLots as $lot)
            <div class="col-md-6 col-lg-4">
                <div class="park-card">
                    <!-- Lot Image Header -->
                    <div style="height: 180px; background: url('{{ $lot->image_url }}') center/cover no-repeat; position: relative;">
                        <div style="position: absolute; inset: 0; background: linear-gradient(to top, var(--bg-card), transparent 70%);"></div>
                        <span class="position-absolute top-0 end-0 m-3 badge bg-dark bg-opacity-75 backdrop-blur text-white border border-secondary">
                            <i class="fa-solid fa-indian-rupee-sign text-warning me-1"></i> ₹{{ number_format($lot->price_per_hour, 2) }} / hr
                        </span>
                        <div class="position-absolute bottom-0 start-0 m-3">
                            <span class="badge-available">
                                <i class="fa-solid fa-circle-check me-1"></i> {{ $lot->available_slots }} / {{ $lot->total_slots }} Slots Open
                            </span>
                        </div>
                    </div>

                    <!-- Lot Body -->
                    <div class="p-4">
                        <h4 class="fw-bold text-white mb-1">{{ $lot->name }}</h4>
                        <p class="text-secondary small mb-3">
                            <i class="fa-solid fa-map-pin text-danger me-1"></i> {{ $lot->location_name }}
                        </p>

                        <!-- Highlights -->
                        <div class="d-flex gap-2 mb-4">
                            <span class="badge bg-secondary bg-opacity-20 text-light border border-secondary small">
                                <i class="fa-solid fa-bolt text-warning me-1"></i> EV Charging
                            </span>
                            <span class="badge bg-secondary bg-opacity-20 text-light border border-secondary small">
                                <i class="fa-solid fa-wheelchair text-info me-1"></i> Accessible
                            </span>
                            <span class="badge bg-secondary bg-opacity-20 text-light border border-secondary small">
                                <i class="fa-solid fa-shield-halved text-success me-1"></i> 24/7 Surveillance
                            </span>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('parking.show', ['id' => $lot->id, 'start_time' => $startTimeStr, 'end_time' => $endTimeStr]) }}" class="btn btn-park-primary w-100 d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-square-parking me-2"></i> Select Slot & Book</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
