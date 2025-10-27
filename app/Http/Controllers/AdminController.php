<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Booking;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $flightCount = Flight::count();
        $bookingCount = Booking::count();
        return view('admin.dashboard', compact('flightCount', 'bookingCount'));
    }

    // Flights list (show all including canceled)
    public function index()
    {
        // Admin sees all flights
        $flights = Flight::orderByDesc('departure_date')->get();
        return view('admin.flights.index', compact('flights'));
    }

    // Show create flight form
    public function createFlight()
    {
        return view('admin.flights.create');
    }

    // Store new flight (validates and saves to DB)
    public function store(Request $request)
    {
        $request->validate([
            'flight_number' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'price' => 'required|numeric|min:0',
            'seats' => 'required|integer|min:0',
        ]);

        Flight::create($request->only([
            'flight_number',
            'origin',
            'destination',
            'departure_date',
            'departure_time',
            'price',
            'seats'
        ]) + ['status' => 'active']);

        return redirect()->route('admin.flights')->with('success', 'Flight added!');
    }

    // Cancel a flight (soft cancel)
    public function cancelFlight($id)
    {
        $flight = Flight::findOrFail($id);
        $flight->status = 'canceled';
        $flight->save();

        return redirect()->route('admin.flights')->with('success', 'Flight canceled. It will be hidden from users.');
    }

    // Restore a canceled flight back to active
    public function restoreFlight($id)
    {
        $flight = Flight::findOrFail($id);
        $flight->status = 'active';
        $flight->save();

        return redirect()->route('admin.flights')->with('success', 'Flight restored to active.');
    }

    // Admin bookings list (with flights for update select)
    public function bookings()
    {
        $bookings = Booking::with(['flight','user'])->orderByDesc('created_at')->get();
        $flights = Flight::orderBy('departure_date')->get();
        return view('admin.bookings', compact('bookings','flights'));
    }

    // Delete booking and restore seats to flight
    public function deleteBooking($id)
    {
        $booking = Booking::findOrFail($id);

        $oldFlight = Flight::find($booking->flight_id);
        if ($oldFlight) {
            if (method_exists($oldFlight, 'increaseSeats')) {
                $oldFlight->increaseSeats($booking->seats_booked);
            } else {
                $oldFlight->seats += $booking->seats_booked;
                $oldFlight->save();
            }
        }

        $booking->delete();
        return redirect()->route('admin.bookings')->with('success','Booking deleted and seats restored.');
    }

    // Mark booking as Success
    public function markSuccess($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'Success';
        $booking->save();

        return redirect()->route('admin.bookings')->with('success','Booking marked as Success.');
    }
}
