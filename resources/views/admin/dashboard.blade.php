@extends('admin.layout')

@section('content')
<h2>Dashboard</h2>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h4>Total Flights</h4>
            <h1>{{ $flightCount }}</h1>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h4>Total Bookings</h4>
            <h1>{{ $bookingCount }}</h1>
        </div>
    </div>
</div>
@endsection
