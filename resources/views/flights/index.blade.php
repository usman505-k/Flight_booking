@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Available Flights</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($flights->isEmpty())
        <div class="alert alert-info">No flights available right now. Check back later.</div>
    @else
        <div class="row g-3">
            @foreach($flights as $flight)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $flight->flight_number }}</h5>
                        <p class="mb-1"><strong>{{ $flight->origin }}</strong> → <strong>{{ $flight->destination }}</strong></p>
                        <p class="mb-1">Date: {{ $flight->departure_date }} | Time: {{ $flight->departure_time }}</p>
                        <p class="mb-1">Price: ${{ number_format($flight->price,2) }}</p>
                        <p class="mb-3 text-muted">Seats left: {{ $flight->seats }}</p>

                        <div class="mt-auto">
                            @auth
                                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#bookModal{{ $flight->id }}">
                                    Book Now
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Login to Book</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOOKING MODAL -->
            <div class="modal fade" id="bookModal{{ $flight->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('bookings.store', $flight->id) }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Book Flight {{ $flight->flight_number }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>{{ $flight->origin }} → {{ $flight->destination }}</strong></p>
                                <p>Date: {{ $flight->departure_date }} | Time: {{ $flight->departure_time }}</p>
                                <p>Price: ${{ number_format($flight->price,2) }}</p>
                                <p class="mb-3">Seats left: <strong>{{ $flight->seats }}</strong></p>

                                <div class="mb-3">
                                    <label class="form-label">Number of seats</label>
                                    <input type="number" name="seats" class="form-control" min="1" max="{{ $flight->seats }}" value="1" required>
                                </div>

                                <div class="form-text">Total will be calculated automatically after booking.</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Confirm Booking</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
