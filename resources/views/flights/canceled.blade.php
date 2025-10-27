@extends('layout.app')

@section('content')
<div class="container py-4">
    <div class="card border-danger">
        <div class="card-body text-center">
            <h3 class="text-danger">This flight has been canceled</h3>
            <p>The flight <strong>{{ $flight->flight_number }}</strong> from <strong>{{ $flight->origin }}</strong> to <strong>{{ $flight->destination }}</strong> on <strong>{{ $flight->departure_date }}</strong> has been canceled by the admin.</p>

            <a href="{{ route('flights.index') }}" class="btn btn-secondary">Back to Available Flights</a>
        </div>
    </div>
</div>
@endsection
