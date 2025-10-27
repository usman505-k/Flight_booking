<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number',
        'origin',
        'destination',
        'departure_date',
        'departure_time',
        'price',
        'seats',
        'status', // added
    ];

    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class);
    }

    // Reduce seats (returns false if not enough)
    public function reduceSeats(int $count)
    {
        if ($this->seats < $count) {
            return false;
        }
        $this->seats -= $count;
        $this->save();
        return true;
    }

    // Increase seats
    public function increaseSeats(int $count)
    {
        $this->seats += $count;
        $this->save();
    }

    // Helper: is canceled?
    public function isCanceled(): bool
    {
        return $this->status === 'canceled';
    }

    // Scope: only active flights
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
