@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Bookings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($bookings->count() > 0)
        @foreach($bookings as $booking)
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title">
                    ✈️ {{ $booking->flight->flight_number }} — {{ $booking->flight->origin }} → {{ $booking->flight->destination }}
                </h5>
                <p class="mb-1"><strong>User:</strong> {{ $booking->user->name }} ({{ $booking->user->email }})</p>
                <p class="mb-1"><strong>Date:</strong> {{ $booking->flight->departure_date }} {{ $booking->flight->departure_time }}</p>
                <p class="mb-1"><strong>Seats:</strong> {{ $booking->seats_booked }}</p>
                <p class="mb-1"><strong>Total:</strong> ${{ number_format($booking->total_amount, 2) }}</p>

                <span class="badge 
                    @if($booking->status == 'Pending') bg-warning
                    @elseif($booking->status == 'Success') bg-success
                    @elseif($booking->status == 'Cancelled') bg-danger
                    @else bg-secondary @endif">
                    {{ $booking->status }}
                </span>

                <div class="mt-3">
                    <!-- Mark Success -->
                    <form action="{{ route('admin.bookings.success', $booking->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">✅ Mark Success</button>
                    </form>

                    <!-- Delete -->
                    <form action="{{ route('admin.bookings.delete', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete booking & restore seats?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">🗑️ Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="alert alert-warning">No bookings found.</div>
    @endif
</div>
@endsection
