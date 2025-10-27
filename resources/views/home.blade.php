@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1>Welcome to Flight Booking System</h1>
    <p>Book flights easily and quickly!</p>

    <a href="{{ route('flights.index') }}" class="btn btn-primary mt-3">View Flights</a>
</div>
@endsection
