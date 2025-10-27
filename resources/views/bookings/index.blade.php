@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">My Bookings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($bookings->count() > 0)
        <div class="row">
            @foreach($bookings as $b)
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $b->flight->flight_name }}</h5>
                            <p class="card-text">
                                ✈ <strong>From:</strong> {{ $b->flight->departure }} <br>
                                🛬 <strong>To:</strong> {{ $b->flight->destination }} <br>
                                📅 <strong>Date:</strong> {{ $b->flight->date }} <br>
                                ⏰ <strong>Time:</strong> {{ $b->flight->time }} <br>
                                💺 <strong>Seats Booked:</strong> {{ $b->seats_booked }}
                            </p>

                             <form action="{{ route('bookings.cancel', $b->id) }}" method="POST">
                             @csrf
                             @method('DELETE')
                             <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                             </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning text-center">
            No bookings found.
        </div>
    @endif
</div>
@endsection
