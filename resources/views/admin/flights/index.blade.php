@extends('admin.layout')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Flights</h2>
        <a href="{{ route('admin.flights.create') }}" class="btn btn-primary">Add Flight</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($flights->isEmpty())
        <div class="alert alert-info">No flights yet.</div>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Flight No</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Price</th>
                    <th>Seats</th>
                </tr>
            </thead>
            <tbody>
                @foreach($flights as $f)
                <tr>
                    <td>{{ $f->id }}</td>
                    <td>{{ $f->flight_number }}</td>
                    <td>{{ $f->origin }}</td>
                    <td>{{ $f->destination }}</td>
                    <td>{{ $f->departure_date }}</td>
                    <td>{{ $f->departure_time }}</td>
                    <td>${{ number_format($f->price,2) }}</td>
                    <td>{{ $f->seats }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
