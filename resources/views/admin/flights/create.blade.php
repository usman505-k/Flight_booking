@extends('admin.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-3">Add New Flight</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.flights.store') }}" method="POST" class="row g-3">
        @csrf
        <div class="col-md-4">
            <label class="form-label">Flight Number</label>
            <input type="text" name="flight_number" class="form-control" required value="{{ old('flight_number') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Origin</label>
            <input type="text" name="origin" class="form-control" required value="{{ old('origin') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Destination</label>
            <input type="text" name="destination" class="form-control" required value="{{ old('destination') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Departure Date</label>
            <input type="date" name="departure_date" class="form-control" required value="{{ old('departure_date') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Departure Time</label>
            <input type="time" name="departure_time" class="form-control" required value="{{ old('departure_time') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required value="{{ old('price') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Seats</label>
            <input type="number" name="seats" class="form-control" required min="0" value="{{ old('seats', 0) }}">
        </div>

        <div class="col-12">
            <button class="btn btn-primary">Add Flight</button>
            <a href="{{ route('admin.flights') }}" class="btn btn-secondary">Back to list</a>
        </div>
    </form>
</div>
@endsection
