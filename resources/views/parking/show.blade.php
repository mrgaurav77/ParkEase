@extends('layouts.app')

@section('title', $parkingLot->name . ' - Select Parking Slot & Book')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb & Back button -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('parking.index', ['start_time' => $startTimeStr, 'end_time' => $endTimeStr]) }}" class="btn btn-park-outline px-3 py-2 text-decoration-none">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to Parking Hubs
        </a>
        <div class="text-end">
            <h4 class="fw-bold mb-0 text-white">{{ $parkingLot->name }}</h4>
            <span class="text-secondary small"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $parkingLot->location_name }}</span>
        </div>
    </div>

    <!-- Error / Success Alert -->
    @if(session('error'))
    <div class="alert alert-danger border-0 bg-danger bg-opacity-20 text-danger rounded-4 p-3 mb-4 d-flex align-items-center">
        <i class="fa-solid fa-triangle-exclamation me-3 fs-4"></i>
        <div>
            <strong>Notice!</strong><br>
            {{ session('error') }}
        </div>
    </div>
    @endif

    <div class="row g-4">
        <!-- Left Column: Single Unified CSS Grid Slot Selector Layout -->
        <div class="col-lg-7">
            <div class="card border-0 p-4" style="background: var(--bg-card); border: 1px solid var(--glass-border) !important; border-radius: 20px;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-bold mb-0 text-white">
                        <i class="fa-solid fa-square-parking text-primary me-2"></i> Parking Slot Layout & Selection
                    </h5>
                    <span class="badge bg-dark text-success border border-success border-opacity-30">
                        <i class="fa-solid fa-indian-rupee-sign me-1"></i> ₹{{ number_format($parkingLot->price_per_hour, 2) }} / hr
                    </span>
                </div>
                <p class="text-secondary small mb-3">Click on any green available slot below to choose your parking bay:</p>

                <!-- Status Legend Bar -->
                <div class="d-flex flex-wrap gap-4 justify-content-center mb-4 py-2 bg-dark bg-opacity-50 rounded-3 border border-secondary border-opacity-25">
                    <div class="d-flex align-items-center gap-2">
                        <span style="width: 14px; height: 14px; background: rgba(16, 185, 129, 0.9); border-radius: 4px; display: inline-block;"></span>
                        <span class="small text-secondary fw-semibold">Available Slot</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="width: 14px; height: 14px; background: rgba(239, 68, 68, 0.9); border-radius: 4px; display: inline-block;"></span>
                        <span class="small text-secondary fw-semibold">Occupied / Booked</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="width: 14px; height: 14px; background: rgba(59, 130, 246, 0.9); border-radius: 4px; display: inline-block;"></span>
                        <span class="small text-secondary fw-semibold">Your Selection</span>
                    </div>
                </div>

                <!-- Single Unified Slot Grid Layout -->
                <div class="slot-grid-container" id="slotGrid">
                    @foreach($slots as $slot)
                    <div class="slot-box {{ $slot->status }} {{ old('slot_id') == $slot->id ? 'selected' : '' }}" 
                         data-slot-id="{{ $slot->id }}" 
                         data-slot-number="{{ $slot->slot_number }}"
                         data-slot-type="{{ $slot->slot_type }}"
                         data-status="{{ $slot->status }}">
                        <div class="slot-number">{{ $slot->slot_number }}</div>
                        <div class="slot-type-tag {{ $slot->slot_type == 'ev' ? 'text-warning' : ($slot->slot_type == 'handicap' ? 'text-info' : 'text-secondary') }}">
                            @if($slot->slot_type == 'ev')
                                <i class="fa-solid fa-bolt me-1"></i> EV
                            @elseif($slot->slot_type == 'handicap')
                                <i class="fa-solid fa-wheelchair me-1"></i> Access
                            @else
                                {{ ucfirst($slot->slot_type) }}
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Driver Booking Form -->
        <div class="col-lg-5">
            <div class="card border-0 p-4 sticky-lg-top" style="top: 90px; background: var(--bg-card); border: 1px solid var(--glass-border) !important; border-radius: 20px;">
                <h4 class="fw-bold text-white mb-3">
                    <i class="fa-solid fa-ticket text-emerald me-2" style="color: var(--accent-green);"></i> Driver Pre-Booking
                </h4>

                @guest
                <div class="alert alert-warning border-0 bg-warning bg-opacity-15 text-warning rounded-3 p-3 mb-4 small">
                    <i class="fa-solid fa-lock me-2"></i> You must be logged in as a driver to pre-book a parking slot.
                </div>
                @endguest

                <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                    @csrf
                    <input type="hidden" name="parking_lot_id" value="{{ $parkingLot->id }}">
                    <input type="hidden" name="slot_id" id="selectedSlotIdInput" value="{{ old('slot_id') }}">

                    <!-- Selected Slot Banner -->
                    <div class="p-3 mb-3 rounded-3 text-center border" id="selectedSlotDisplay" style="background: #0f172a; border-color: var(--border-color) !important;">
                        <span class="text-secondary small d-block mb-1">Selected Parking Bay</span>
                        <h3 class="fw-bold text-success mb-0" id="selectedSlotText">
                            {{ old('slot_id') ? 'Slot Selected' : 'Click a Slot on Grid' }}
                        </h3>
                    </div>

                    <!-- Time Window Info -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">Start Time</label>
                            <input type="datetime-local" name="start_time" class="form-control form-control-sm bg-dark text-white border-secondary" value="{{ $startTimeStr }}" id="startTimeInput" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">End Time</label>
                            <input type="datetime-local" name="end_time" class="form-control form-control-sm bg-dark text-white border-secondary" value="{{ $endTimeStr }}" id="endTimeInput" required>
                        </div>
                    </div>

                    <!-- Vehicle & Driver Details -->
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Vehicle License Plate</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-secondary border-secondary"><i class="fa-solid fa-car"></i></span>
                            <input type="text" name="vehicle_number" class="form-control bg-dark text-white border-secondary text-uppercase fw-bold" placeholder="e.g. MH-15-AB-1234" value="{{ old('vehicle_number') }}" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">Vehicle Type</label>
                            <select name="vehicle_type" class="form-select form-select-sm bg-dark text-white border-secondary">
                                <option value="car">Car (Standard)</option>
                                <option value="suv">SUV / Truck</option>
                                <option value="ev">Electric Vehicle (EV)</option>
                                <option value="bike">Motorcycle / Bike</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">Driver Name</label>
                            <input type="text" name="owner_name" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="Full Name" value="{{ old('owner_name', Auth::user()->name ?? '') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Email for Receipt</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-dark text-secondary border-secondary"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="owner_email" class="form-control bg-dark text-white border-secondary" placeholder="driver@example.com" value="{{ old('owner_email', Auth::user()->email ?? '') }}" required>
                        </div>
                    </div>

                    <!-- Estimated Summary -->
                    <div class="bg-dark p-3 rounded-3 mb-4 border border-secondary border-opacity-30">
                        <div class="d-flex justify-content-between text-secondary small mb-1">
                            <span>Rate / hour:</span>
                            <span>₹{{ number_format($parkingLot->price_per_hour, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-secondary small mb-2">
                            <span>Duration:</span>
                            <span id="durationHoursDisplay">{{ $hours }} hour(s)</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold text-white fs-5 border-top border-secondary border-opacity-20 pt-2">
                            <span>Total Estimated:</span>
                            <span class="text-success" id="totalPriceDisplay">₹{{ number_format($hours * $parkingLot->price_per_hour, 2) }}</span>
                        </div>
                    </div>

                    <!-- Submit Button vs Login Requirement -->
                    @auth
                    <button type="submit" class="btn btn-park-primary w-100 py-3 fw-bold fs-6" id="submitBtn">
                        <i class="fa-solid fa-circle-check me-2"></i> Confirm Pre-Booking
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-park-primary w-100 py-3 fw-bold fs-6 text-decoration-none text-center">
                        <i class="fa-solid fa-right-to-bracket me-2"></i> Log In to Confirm Pre-Booking
                    </a>
                    @endauth
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const hourlyRate = {{ $parkingLot->price_per_hour }};
    let selectedSlotId = null;

    const selectedSlotInput = document.getElementById('selectedSlotIdInput');
    const selectedSlotText = document.getElementById('selectedSlotText');
    const bookingForm = document.getElementById('bookingForm');

    const startTimeInput = document.getElementById('startTimeInput');
    const endTimeInput = document.getElementById('endTimeInput');
    const durationHoursDisplay = document.getElementById('durationHoursDisplay');
    const totalPriceDisplay = document.getElementById('totalPriceDisplay');

    // Calculate Price on time input change
    function updatePrice() {
        const start = new Date(startTimeInput.value);
        const end = new Date(endTimeInput.value);
        if (start && end && end > start) {
            const diffMs = end - start;
            const hours = Math.max(1, Math.ceil(diffMs / (1000 * 60 * 60)));
            durationHoursDisplay.innerText = hours + ' hour(s)';
            totalPriceDisplay.innerText = '₹' + (hours * hourlyRate).toFixed(2);
        }
    }

    startTimeInput.addEventListener('change', updatePrice);
    endTimeInput.addEventListener('change', updatePrice);

    // Handle Slot Selection on CSS Grid
    function selectSlot(slotId, slotNumber, status) {
        if (status === 'occupied') {
            alert('Slot ' + slotNumber + ' is already occupied or booked for this time window! Please choose another slot.');
            return;
        }

        selectedSlotId = slotId;
        selectedSlotInput.value = slotId;
        selectedSlotText.innerText = 'Slot ' + slotNumber + ' Selected';
        selectedSlotText.className = 'fw-bold text-success mb-0';

        // Highlight selected box in grid
        document.querySelectorAll('.slot-box').forEach(box => {
            box.classList.remove('selected');
            if (box.dataset.slotId == slotId) {
                box.classList.add('selected');
            }
        });
    }

    document.querySelectorAll('.slot-box').forEach(box => {
        box.addEventListener('click', function() {
            selectSlot(this.dataset.slotId, this.dataset.slotNumber, this.dataset.status);
        });
    });

    // Auto-select first available slot on load if not already selected
    const initialSlotId = selectedSlotInput.value;
    if (initialSlotId) {
        const initialBox = document.querySelector(`.slot-box[data-slot-id="${initialSlotId}"]`);
        if (initialBox) {
            selectSlot(initialBox.dataset.slotId, initialBox.dataset.slotNumber, initialBox.dataset.status);
        }
    } else {
        const firstAvailableBox = document.querySelector('.slot-box.available');
        if (firstAvailableBox) {
            selectSlot(firstAvailableBox.dataset.slotId, firstAvailableBox.dataset.slotNumber, firstAvailableBox.dataset.status);
        }
    }

    // Form Submission Validation
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            if (!selectedSlotInput.value) {
                e.preventDefault();
                alert('Please select an available parking slot from the grid layout before confirming!');
            }
        });
    }
});
</script>
@endsection
