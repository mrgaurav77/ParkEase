<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation - ParkEase Nashik</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a; color: #f8fafc; margin: 0; padding: 20px; }
        .card { max-width: 600px; margin: 0 auto; background: #1e293b; border-radius: 12px; padding: 30px; border: 1px solid #334155; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 1px solid #334155; }
        .brand { font-size: 24px; font-weight: bold; color: #10b981; text-transform: uppercase; letter-spacing: 1px; }
        .reference { background: #064e3b; color: #34d399; font-weight: bold; padding: 6px 16px; border-radius: 20px; display: inline-block; margin-top: 10px; font-family: monospace; font-size: 16px; }
        .details { margin: 25px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #334155; }
        .label { color: #94a3b8; font-size: 14px; }
        .value { color: #ffffff; font-weight: 600; font-size: 14px; text-align: right; }
        .total-box { background: #0f172a; border-radius: 8px; padding: 15px; margin-top: 20px; text-align: center; border: 1px solid #10b981; }
        .total-label { color: #94a3b8; font-size: 13px; text-transform: uppercase; }
        .total-amount { color: #10b981; font-size: 28px; font-weight: bold; margin-top: 4px; }
        .footer { text-align: center; margin-top: 25px; color: #64748b; font-size: 12px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="brand">🚗 ParkEase Nashik</div>
            <h2>Parking Slot Reserved!</h2>
            <div class="reference">{{ $booking->booking_reference }}</div>
        </div>

        <div class="details">
            <div class="detail-row">
                <span class="label">Driver Name:</span>
                <span class="value">{{ $booking->vehicle->owner_name }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Vehicle Plate:</span>
                <span class="value">{{ $booking->vehicle->vehicle_number }} ({{ strtoupper($booking->vehicle->vehicle_type) }})</span>
            </div>
            <div class="detail-row">
                <span class="label">Location:</span>
                <span class="value">{{ $booking->parkingLot->name }} ({{ $booking->parkingLot->location_name }})</span>
            </div>
            <div class="detail-row">
                <span class="label">Assigned Slot:</span>
                <span class="value" style="color:#10b981; font-weight:bold;">Slot {{ $booking->slot->slot_number }} ({{ $booking->slot->floor }})</span>
            </div>
            <div class="detail-row">
                <span class="label">Start Time:</span>
                <span class="value">{{ $booking->start_time->format('D, M d Y @ h:i A') }}</span>
            </div>
            <div class="detail-row">
                <span class="label">End Time:</span>
                <span class="value">{{ $booking->end_time->format('D, M d Y @ h:i A') }}</span>
            </div>
        </div>

        <div class="total-box">
            <div class="total-label">Total Parking Fee to be Paid</div>
            <div class="total-amount">₹{{ number_format($booking->total_amount, 2) }}</div>
        </div>

        <div class="footer">
            Thank you for choosing ParkEase Nashik Smart City Parking Services.<br>
            Please present this confirmation reference at entry gate.
        </div>
    </div>
</body>
</html>
