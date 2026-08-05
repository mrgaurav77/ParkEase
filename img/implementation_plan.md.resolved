# Implementation Plan - ParkEase (City Parking Finder & Pre-Booking System)

**ParkEase** is a Smart City parking slot finder and pre-booking web application built using **Laravel**, **Bootstrap CSS3**, **HTML5 Canvas**, **Eloquent ORM**, and **MySQL/SQLite**. It allows drivers to view interactive, color-coded parking lot canvas layouts in real time, check slot availability across target time windows, prevent booking conflicts, and receive booking confirmation emails.

---

## Technical Architecture & Database Schema

### Database Models & Tables
1. **`parking_lots`**
   - `id`, `name`, `location_name`, `address`, `total_slots`, `price_per_hour`, `latitude`, `longitude`, `created_at`, `updated_at`
2. **`slots`**
   - `id`, `parking_lot_id` (FK), `slot_number` (e.g. A1, A2, B1), `slot_type` (`regular`, `ev`, `handicap`, `compact`), `floor` (e.g. Ground, Level 1), `x_coord`, `y_coord` (for Canvas positioning), `is_active`, `created_at`, `updated_at`
3. **`vehicles`**
   - `id`, `vehicle_number`, `vehicle_type` (`car`, `suv`, `bike`, `ev`), `owner_name`, `owner_email`, `owner_phone`, `created_at`, `updated_at`
4. **`bookings`**
   - `id`, `booking_reference` (unique code e.g. `PK-892F1`), `parking_lot_id` (FK), `slot_id` (FK), `vehicle_id` (FK), `start_time` (datetime), `end_time` (datetime), `total_amount` (decimal), `status` (`confirmed`, `cancelled`, `completed`), `created_at`, `updated_at`

---

## User Review Required

> [!NOTE]
> - **Database Engine**: We will initialize the application with SQLite by default for zero-config immediate execution and testing in local environment, while providing standard MySQL migrations and seeders ready for deployment (e.g. Hostinger).
> - **Email Confirmation**: Laravel Mail will be configured with `log` / SMTP options, rendering rich HTML booking receipts with full ticket breakdown.

---

## Proposed Changes

### Core Project Creation & Setup
- Create new Laravel 11/10 application in `d:\Desktop\caseStudies\ParkEase` using Composer.
- Configure `.env`, Bootstrap 5 assets/CDN, and custom CSS styling.

### [NEW] Database Migrations & Eloquent Models
- Create `ParkingLot`, `Slot`, `Vehicle`, and `Booking` models with relations.
- Create migration files for `parking_lots`, `slots`, `vehicles`, and `bookings`.
- Create `DatabaseSeeder` with sample data for **3 Smart City Locations**:
  1. *Metro Central Garage* (Downtown Metro)
  2. *Tech Hub Plaza Parking* (IT District)
  3. *Grand City Mall Deck* (Commercial Hub)

### [NEW] Controller Logic & Conflict Detection
- **`ParkingController`**:
  - `index()`: Display list of parking lots with live availability counts.
  - `show($id)`: Interactive Canvas map & CSS Grid slot view for selected parking lot.
- **`BookingController`**:
  - `store()`: Validate vehicle entry, perform **time slot conflict detection logic**:
    ```php
    $conflict = Booking::where('slot_id', $slotId)
        ->where('status', 'confirmed')
        ->where(function ($q) use ($startTime, $endTime) {
            $q->where('start_time', '<', $endTime)
              ->where('end_time', '>', $startTime);
        })->exists();
    ```
  - `confirmation($reference)`: Display confirmation receipt page.
- **`ApiController`**:
  - `GET /api/parking-lots`: JSON list of lots.
  - `GET /api/parking-lots/{id}/slots`: JSON slot list with current slot status for a time window.
  - `GET /api/slots/check-availability`: Real-time availability check API endpoint.
  - `POST /api/bookings`: API endpoint for booking creation.

### [NEW] Frontend Layout & HTML5 Canvas Visualization
- **HTML5 Canvas Map**: Real-time canvas renderer plotting slots (`x_coord`, `y_coord`), lanes, entry/exit gates, and status indicator overlays.
- **CSS3 Grid Slot Visualizer**: Color-coded slots (Green = Available, Red = Occupied/Booked, Blue = Selected).
- **Responsive Driver Portal**: Optimized mobile view for drivers to filter by city location, select time slot, pick slot, enter vehicle details, and confirm booking.
- **Email Notification**: `BookingConfirmationMail` Mailable class + responsive Blade HTML template.

---

## Verification Plan

### Automated & API Verification
- Run Laravel artisan commands (`php artisan migrate --fresh --seed`).
- Validate REST API endpoints returning correct slot availability JSON payload.

### Manual Visual & Functional Verification
- Test selecting time slots and verifying slot availability changes dynamically on HTML5 Canvas & Grid layout.
- Test booking a slot for a specific time range, verify conflict prevention when attempting to double-book the same slot at overlapping times.
- Validate mobile responsiveness and email layout formatting.
