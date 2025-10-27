@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-body">
            <h3>{{ $flight->flight_number }} — {{ $flight->origin }} → {{ $flight->destination }}</h3>
            <p>📅 <strong>Date:</strong> {{ $flight->departure_date }}</p>
            <p>⏰ <strong>Time:</strong> {{ $flight->departure_time }}</p>
            <p>💺 <strong>Seats Available:</strong> {{ $flight->seats }}</p>
            <p>💲 <strong>Price:</strong> ${{ number_format($flight->price,2) }}</p>

            @auth
                <form action="{{ route('bookings.store', $flight->id) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label>Seats to book</label>
                        <input type="number" name="seats" class="form-control" min="1" max="{{ $flight->seats }}" value="1" required>
                    </div>
                    <button class="btn btn-success">Confirm Booking</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login to Book</a>
            @endauth
        </div>
    </div>
</div>
@endsection
