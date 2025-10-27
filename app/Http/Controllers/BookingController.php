<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Flight;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Show user's bookings
    public function index()
    {
        $bookings = Booking::with('flight')->where('user_id', auth()->id())->orderByDesc('created_at')->get();
        return view('bookings.index', compact('bookings'));
    }

    // Store a new booking (user-side)
   public function store(Request $request, $flightId)
    {
        $request->validate([
            'seats' => 'required|integer|min:1',
        ]);

        $flight = Flight::findOrFail($flightId);

        if ($flight->isCanceled()) {
            return redirect()->route('flights.index')->with('error', 'Cannot book a canceled flight.');
        }

        $seats = (int) $request->input('seats', 1);

        if ($flight->seats < $seats) {
            return redirect()->back()->with('error', 'Not enough seats available.');
        }

        // reduce seats
        $flight->seats -= $seats;
        $flight->save();

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'flight_id' => $flight->id,
            'seats_booked' => $seats,
            'total_amount' => $flight->price * $seats,
            'status' => 'Pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking confirmed!');
    }


    public function cancel($id)
{
    $booking = Booking::findOrFail($id);

    if ($booking->status === 'confirmed') {
        return redirect()->back()->with('error', 'You cannot cancel a confirmed booking.');
    }

    $booking->delete();

    return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully.');
}

    // User updates booking (change seats or flight)
    public function update(Request $request, $id)
    {
        $request->validate([
            'flight_id' => 'required|integer|exists:flights,id',
            'seats_booked' => 'required|integer|min:1',
        ]);

        $booking = Booking::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $oldFlight = Flight::find($booking->flight_id);
        $newFlight = Flight::find($request->flight_id);

        $newSeats = (int)$request->seats_booked;
        $oldSeats = (int)$booking->seats_booked;

        // If flight changed
        if ($booking->flight_id != $newFlight->id) {
            // restore old seats
            if ($oldFlight) {
                if (method_exists($oldFlight, 'increaseSeats')) {
                    $oldFlight->increaseSeats($oldSeats);
                } else {
                    $oldFlight->seats += $oldSeats;
                    $oldFlight->save();
                }
            }

            // try take seats on new flight
            $reduced = false;
            if (method_exists($newFlight, 'reduceSeats')) {
                $reduced = $newFlight->reduceSeats($newSeats);
            } else {
                if ($newFlight->seats >= $newSeats) {
                    $newFlight->seats -= $newSeats;
                    $newFlight->save();
                    $reduced = true;
                }
            }

            if (!$reduced) {
                // rollback old flight seats (best effort)
                if ($oldFlight) {
                    if (method_exists($oldFlight, 'reduceSeats')) {
                        $oldFlight->reduceSeats($oldSeats);
                    } else {
                        $oldFlight->seats -= $oldSeats;
                        $oldFlight->save();
                    }
                }
                return redirect()->route('bookings.index')->with('error','Not enough seats on selected flight.');
            }

            $booking->flight_id = $newFlight->id;
            $booking->seats_booked = $newSeats;
        } else {
            // same flight adjust seats
            $diff = $newSeats - $oldSeats;
            if ($diff > 0) {
                if (method_exists($oldFlight, 'reduceSeats')) {
                    $ok = $oldFlight->reduceSeats($diff);
                    if (!$ok) return back()->with('error','Not enough seats.');
                } else {
                    if ($oldFlight->seats < $diff) return back()->with('error','Not enough seats.');
                    $oldFlight->seats -= $diff;
                    $oldFlight->save();
                }
            } elseif ($diff < 0) {
                if ($oldFlight) {
                    if (method_exists($oldFlight, 'increaseSeats')) {
                        $oldFlight->increaseSeats(abs($diff));
                    } else {
                        $oldFlight->seats += abs($diff);
                        $oldFlight->save();
                    }
                }
            }
            $booking->seats_booked = $newSeats;
        }

        // recalc total
        $flightForPrice = $newFlight ?? $oldFlight;
        if ($flightForPrice) {
            $booking->total_amount = $flightForPrice->price * $booking->seats_booked;
        }

        $booking->save();

        return redirect()->route('bookings.index')->with('success','Booking updated successfully.');
    }
}
