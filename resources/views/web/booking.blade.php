<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Booking Form</h2>
        
        <form action="{{ route('customer.booking_add') }}" method="POST">
            @csrf
            @include('web.common.flash')

            <!-- Customer Name -->
            <div class="mb-3">
                <label for="customer_name" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>

            <!-- Customer Email -->
            <div class="mb-3">
                <label for="customer_email" class="form-label">Customer Email</label>
                <input type="email" class="form-control" id="customer_email" name="customer_email" required>
            </div>

            <!-- Booking Date -->
            <div class="mb-3">
                <label for="booking_date" class="form-label">Booking Date</label>
                <input type="date" class="form-control" id="booking_date" name="booking_date" required 
                       min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                       @foreach ($booked_dates as $booked_date)
                           data-disabled-dates="{{ $booked_date }}"
                       @endforeach>
            </div>

            <!-- Booking Type -->
            <div class="mb-3">
                <label for="booking_type" class="form-label">Booking Type</label>
                <select class="form-select" id="booking_type" name="booking_type" required>
                    <option value="Full Day">Full Day</option>
                    <option value="Half Day">Half Day</option>
                    <option value="Custom">Custom</option>
                </select>
            </div>

            <!-- Booking Slot (Visible if Half Day) -->
            <div class="mb-3" id="booking_slot_section" style="display: none;">
                <label for="booking_slot" class="form-label">Booking Slot</label>
                <select class="form-select" id="booking_slot" name="booking_slot">
                    <option value="First Half">First Half</option>
                    <option value="Second Half">Second Half</option>
                </select>
            </div>

            <!-- Booking Time (Visible if Custom) -->
            <div class="mb-3" id="booking_time_section" style="display: none;">
                <label for="booking_from" class="form-label">Booking Time (From)</label>
                <input type="time" class="form-control" id="booking_from" name="booking_from">

                <label for="booking_to" class="form-label mt-3">Booking Time (To)</label>
                <input type="time" class="form-control" id="booking_to" name="booking_to">
            </div>

            <button type="submit" class="btn btn-primary">Submit Booking</button>
        </form>
    </div>

    <script>
        const bookedDates = @json($booked_dates); 
        const bookedTimes = @json($booked_times);

        const bookingDateInput = document.getElementById('booking_date');
        const bookingFromInput = document.getElementById('booking_from');
        const bookingToInput = document.getElementById('booking_to');
        const bookingTypeSelect = document.getElementById('booking_type');
        const bookingSlotSection = document.getElementById('booking_slot_section');
        const bookingTimeSection = document.getElementById('booking_time_section');

        
        function disableTimeSlots(selectedDate) {
            const bookedSlotsForSelectedDate = bookedTimes[selectedDate] || [];

            
            const timeOptions = bookingFromInput.querySelectorAll('option');
            timeOptions.forEach(option => {
                option.disabled = false;
            });

    
            bookedSlotsForSelectedDate.forEach(booking => {
                const bookedFromTime = booking.booking_from;
                const bookedToTime = booking.booking_to;

                   const allTimes = ["00:00", "01:00", "02:00", "03:00", "04:00", "05:00", "06:00", "07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"];
                
                allTimes.forEach(time => {
                    if (time >= bookedFromTime && time < bookedToTime) {
                        const timeOption = bookingFromInput.querySelector(`option[value="${time}"]`);
                        if (timeOption) timeOption.disabled = true;
                    }
                });
            });
        }

    
        bookingDateInput.addEventListener('change', function () {
            const selectedDate = this.value;
            disableTimeSlots(selectedDate);
        });

    
        bookingTypeSelect.addEventListener('change', function () {
            if (this.value === 'Half Day') {
                bookingSlotSection.style.display = 'block';
                bookingTimeSection.style.display = 'none';
            } else if (this.value === 'Custom') {
                bookingSlotSection.style.display = 'none';
                bookingTimeSection.style.display = 'block';
            } else {
                bookingSlotSection.style.display = 'none';
                bookingTimeSection.style.display = 'none';
            }
        });

    
        function isTimeConflict(selectedDate, selectedFromTime, selectedToTime) {
            const bookedSlotsForSelectedDate = bookedTimes[selectedDate] || [];
            
            return bookedSlotsForSelectedDate.some(booking => {
                const bookedFromTime = booking.booking_from;
                const bookedToTime = booking.booking_to;

    
                return (selectedFromTime >= bookedFromTime && selectedFromTime < bookedToTime) || 
                       (selectedToTime > bookedFromTime && selectedToTime <= bookedToTime);
            });
        }

    
        bookingFromInput.addEventListener('input', function () {
            const selectedDate = bookingDateInput.value;
            const selectedFromTime = this.value;
            const selectedToTime = bookingToInput.value;

            if (isTimeConflict(selectedDate, selectedFromTime, selectedToTime)) {
                alert('This time range overlaps with an existing booking.');
                bookingFromInput.value = ''; 
            }
        });

        bookingToInput.addEventListener('input', function () {
            const selectedDate = bookingDateInput.value;
            const selectedFromTime = bookingFromInput.value;
            const selectedToTime = this.value;

            if (isTimeConflict(selectedDate, selectedFromTime, selectedToTime)) {
                alert('This time range overlaps with an existing booking.');
                bookingToInput.value = ''; 
            }
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
