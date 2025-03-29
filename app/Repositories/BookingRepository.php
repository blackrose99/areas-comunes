<?php

namespace App\Repositories;

use App\Models\Booking;

class BookingRepository
{
    public function createBooking(array $data)
    {
        return Booking::create($data);
    }
}
