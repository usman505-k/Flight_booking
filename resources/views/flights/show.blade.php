@extends('layouts.app')

@section('content')
<h2>Flight Details</h2>

<div class="card p-3">
    <p><strong>From:</strong> {{ $flight->departure }}</p>
    <p><strong>To:</strong> {{ $flight->destination }}</p>
    <p><strong>Date:</strong> {{ $flight->date }}</p>
    <p><strong>Seats:</strong> {{ $flight->seats }}</p>
    <p><strong>Price:</strong> ${{ $flight->price }}</p>
</div>

@auth
<form action="{{ route('bookings.store', $flight->id) }}" method="POST" class="mt-3">
    @csrf
    <button class="btn btn-success">Book This Flight</button>
</form>
@else
<div class="alert alert-info mt-3">
    Please <a href="{{ route('login') }}">login</a> to book this flight.
</div>
@endauth
@endsection
