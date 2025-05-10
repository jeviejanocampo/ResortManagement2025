<!-- filepath: resources/views/pdf/booking.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Official Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .card { border: 1px solid #ccc; border-radius: 8px; }
        .card-body { padding: 2rem; }
        hr { margin: 1rem 0; }
    </style>
</head>
<body>
<div class="card">
  <div class="card-body mx-4">
    <div class="container">
      <p class="my-5 mx-5" style="font-size: 30px;">Thank you for your purchase</p>
      <div class="row">
        <ul class="list-unstyled">
          <li class="text-black">{{ $booking->guest_name }}</li>
          <li class="text-muted mt-1"><span class="text-black">Invoice</span> #{{ $booking->booking_id }}</li>
          <li class="text-black mt-1">{{ $booking->created_at->format('F d, Y') }}</li>
        </ul>
        <hr>
        <div class="col-xl-10">
          <p>Room Booking</p>
        </div>
        <div class="col-xl-2">
          <p class="float-end">₱{{ number_format($booking->payment->total_amount, 2) }}</p>
        </div>
        <hr>
      </div>
      @if($booking->extra_pax > 0)
      <div class="row">
        <div class="col-xl-10">
          <p>Extra Pax</p>
        </div>
        <div class="col-xl-2">
          <p class="float-end">₱{{ number_format($booking->room->rate_per_pax * $booking->extra_pax, 2) }}</p>
        </div>
        <hr>
      </div>
      @endif
      <div class="row text-black">
        <div class="col-xl-12">
          <p class="float-end fw-bold">Total: ₱{{ number_format($booking->payment->total_amount, 2) }}</p>
        </div>
        <hr style="border: 2px solid black;">
      </div>
      <div class="text-center" style="margin-top: 90px;">
        <a><u class="text-info">View in browser</u></a>
        <p>Thank you for choosing our resort!</p>
      </div>
    </div>
  </div>
</div>
</body>
</html>