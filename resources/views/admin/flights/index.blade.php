@extends('admin.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Flights</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.flights.create') }}" class="btn btn-primary">Create Flight</a>
    </div>

    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Flight #</th>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Time</th>
                <th>Seats</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($flights as $flight)
                @php $isCanceled = $flight->status === 'canceled'; @endphp
                <tr @if($isCanceled) style="background:#f4f4f4;color:#b02a37;" @endif>
                    <td>{{ $flight->id }}</td>
                    <td>{{ $flight->flight_number }}</td>
                    <td>{{ $flight->origin }}</td>
                    <td>{{ $flight->destination }}</td>
                    <td>{{ $flight->departure_date }}</td>
                    <td>{{ $flight->departure_time }}</td>
                    <td>{{ $flight->seats }}</td>
                    <td>${{ number_format($flight->price,2) }}</td>
                    <td>
                        @if($isCanceled)
                            <span class="badge bg-danger">CANCELED</span>
                        @else
                            <span class="badge bg-success">ACTIVE</span>
                        @endif
                    </td>
                    <td style="min-width:220px">
                        @if($isCanceled)
                            <form action="{{ route('admin.flights.restore', $flight->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">Undo Cancel</button>
                            </form>
                        @else
                            <form action="{{ route('admin.flights.cancel', $flight->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this flight? It will be hidden from users.')">
                                @csrf
                                <button class="btn btn-sm btn-danger">Cancel Flight</button>
                            </form>
                        @endif

                        <!-- Optionally: view bookings for this flight -->
                        <a href="{{ route('admin.bookings') }}?flight_id={{ $flight->id }}" class="btn btn-sm btn-secondary">View Bookings</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
