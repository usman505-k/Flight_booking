@extends('layouts.app') {{-- or your main layout file --}}

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Available Flights</h2>

    @if($flights->isEmpty())
        <div class="alert alert-warning">No flights available right now.</div>
    @else
        <div class="row g-3">
            @foreach($flights as $flight)
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $flight->flight_number }}</h5>
                            <p class="card-text mb-1"><strong>{{ $flight->origin }}</strong> → <strong>{{ $flight->destination }}</strong></p>
                            <p class="mb-1">📅 <strong>Date:</strong> {{ $flight->departure_date }}</p>
                            <p class="mb-1">⏰ <strong>Time:</strong> {{ $flight->departure_time }}</p>
                            <p class="mb-1">💺 <strong>Seats:</strong> {{ $flight->seats }}</p>
                            <p class="mb-3">💲 <strong>Price:</strong> ${{ number_format($flight->price,2) }}</p>

                            <div class="mt-auto">
                                <a href="{{ route('flights.show', $flight->id) }}" class="btn btn-primary w-100">View / Book</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
