@extends('layouts.vertical', ['title' => 'Room Availability'])

@section('content')
<div class="container-fluid">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <a href="{{ url()->previous() }}">
                <span class="mdi mdi-arrow-left-thin fs-2 mt-auto"></span>
            </a>
            <span class="fs-5 fw-semibold">Availability of Room #{{ $room->room_number }}</span>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body app-calendar">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="booking-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="booking-form" method="POST" action="{{ route('room.booking', $room->room_id) }}">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->room_id }}">
                    <input type="hidden" name="rate_per_night" id="rate_per_night" value="{{ $room->rate_per_night }}">
                    <input type="hidden" name="rate_per_pax" id="rate_per_pax" value="{{ $room->rate_per_pax }}">
                    <div class="modal-header">
                        <h5 class="modal-title">New Booking for Room #{{ $room->room_number }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="step-1" class="modal-body">
                        <h6 class="mb-3 border-bottom pb-2 fw-bold">Guest Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="guest_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="guest_name" name="guest_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="guest_phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="guest_phone" name="guest_phone" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="guest_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="guest_email" name="guest_email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="guest_address" class="form-label">Full Address</label>
                                <input type="text" class="form-control" id="guest_address" name="guest_address">
                            </div>
                        </div>
                        <h6 class="mb-3 border-bottom pb-2 fw-bold">Booking Details</h6>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="check_in_date" class="form-label">Check-in Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="check_out_date" class="form-label">Check-out Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="extra_pax" class="form-label">Extra Pax</label>
                                <input type="number" class="form-control" id="extra_pax" name="extra_pax" value="0" min="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="special_requests" class="form-label">Special Requests</label>
                            <textarea class="form-control" id="special_requests" name="special_requests" rows="2"></textarea>
                        </div>
                        <div class="alert alert-info">
                            <div class="d-flex justify-content-between">
                                <span>Room Rate: <strong id="display_room_rate">₱{{ number_format($room->rate_per_night, 2) }}</strong></span>
                                <span>Rate Per Pax: <strong>₱{{ number_format($room->rate_per_pax, 2) }}</strong></span>
                                <span>Total: <strong id="display_total_amount">₱0.00</strong></span>
                            </div>
                        </div>
                    </div>
                    <div id="step-2" class="modal-body d-none">
                        <h6 class="mb-3 border-bottom pb-2 fw-bold">Payment Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="total_amount" class="form-label">Total Amount</label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option selected disabled value="">Choose...</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="online_payment">Online Payment</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="reference_number" class="form-label">Reference Number</label>
                                <input type="text" class="form-control" id="reference_number" name="reference_number">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="amount_paid" class="form-label">Amount Paid</label>
                                <input type="number" class="form-control" id="amount_paid" name="amount_paid">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="payment_notes" class="form-label">Payment Notes</label>
                            <textarea class="form-control" id="payment_notes" name="payment_notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancel-button">Cancel</button>
                        <button type="button" class="btn btn-light d-none" id="prev-step" onclick="showStep(1)">Back</button>
                        <button type="button" class="btn btn-primary" id="next-step" onclick="showStep(2)">Next</button>
                        <button type="submit" class="btn btn-primary d-none" id="submit-button">
                            <i class="fas fa-check me-1"></i> Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @vite([
        'resources/js/pages/room.calendar.js',
    ])
    
    <script>
        const roomId = {{ $room->room_id }};
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('check_in_date').min = today;
            document.getElementById('check_out_date').min = today;
            
            document.getElementById('check_in_date').addEventListener('change', updateTotalDisplay);
            document.getElementById('check_out_date').addEventListener('change', updateTotalDisplay);
            document.getElementById('extra_pax').addEventListener('input', updateTotalDisplay);
            document.getElementById('amount_paid').addEventListener('input', calculateChange);
            
            updateTotalDisplay();
        });

        function updateTotalDisplay() {
            const total = calculateTotal();
            document.getElementById('display_total_amount').textContent = '₱' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            if (document.getElementById('total_amount')) {
                document.getElementById('total_amount').value = total.toFixed(2);
            }

            if (!document.getElementById('step-2').classList.contains('d-none')) {
                calculateChange();
            }
        }

        function calculateTotal() {
            const checkInDateValue = document.getElementById('check_in_date').value;
            const checkOutDateValue = document.getElementById('check_out_date').value;

            if (!checkInDateValue || !checkOutDateValue) {
                return 0;
            }

            const checkInDate = new Date(checkInDateValue);
            const checkOutDate = new Date(checkOutDateValue);
            const extraPax = parseInt(document.getElementById('extra_pax').value) || 0;
            const roomRate = parseFloat(document.getElementById('rate_per_night').value);
            const paxRate = parseFloat(document.getElementById('rate_per_pax').value);

            if (checkOutDate < checkInDate) {
                return 0;
            }

            const timeDiff = checkOutDate - checkInDate;
            const nights = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

            const roomTotal = roomRate * nights;
            const extraPaxTotal = paxRate * extraPax * nights;
            return roomTotal + extraPaxTotal;
        }

        function showStep(step) {
            document.getElementById('step-1').classList.toggle('d-none', step !== 1);
            document.getElementById('step-2').classList.toggle('d-none', step !== 2);
            document.getElementById('next-step').classList.toggle('d-none', step === 2);
            document.getElementById('prev-step').classList.toggle('d-none', step === 1);
            document.getElementById('submit-button').classList.toggle('d-none', step !== 2);
            document.getElementById('cancel-button').classList.toggle('d-none', step !== 1); // Hide on step 2
        }
    </script>
@endsection