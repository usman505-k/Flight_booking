<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;

class FlightController extends Controller
{
    // public list (only active)
    public function index()
    {
        $flights = Flight::active()->orderBy('departure_date')->get();
        return view('flights.index', compact('flights'));
    }

    // show flight details, but if canceled show message
    public function show($id)
    {
        $flight = Flight::findOrFail($id);

        if ($flight->isCanceled()) {
            // show a friendly canceled page (no booking)
            return view('flights.canceled', compact('flight'));
        }

        return view('flights.show', compact('flight'));
    }
}
