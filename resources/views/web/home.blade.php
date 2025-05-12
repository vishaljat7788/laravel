<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Calendar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css">
</head>
<body>


    <div class="container mt-5">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('customer.booking') }}" class="btn btn-success">Add New Booking</a>
        </div>

        <!-- Booking Data Table -->
        <div class="card shadow p-4">
            <h2 class="mb-4 text-center">Booking List</h2>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Booking Date</th>
                        <th>Booking Type</th>
                        <th>Booking Slot</th>
                        <th>Booking Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->customer_email }}</td>
                            <td>{{ $booking->booking_date }}</td>
                            <td>{{ $booking->booking_type }}</td>
                            <td>{{ $booking->booking_slot ?? '-' }}</td>
                            <td>
                                @if ($booking->booking_type === 'Custom')
                                    {{ $booking->booking_from }} - {{ $booking->booking_to }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>