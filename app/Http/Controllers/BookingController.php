<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Booking;
use App\Services\BookingService;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Obtener todas las áreas disponibles.
     */

    public function getAreas()
    {
        $areas = Area::all();
        return response()->json($areas);
    }


    /**
     * Obtener todas las reservas registradas.
     */
    public function getBookings()
    {
        $bookings = Booking::with('resident', 'area')->get();
        return response()->json($bookings);
    }

    /**
     * Crear una nueva reservación.
     */
    public function createBooking(Request $request)
    {
        $data = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'area_id' => 'required|exists:areas,id',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer',
            'status' => 'required|in:pending,approved,rejected',
            'comments' => 'nullable|string'
        ]);

        $booking = $this->bookingService->createBooking($data);

        return response()->json([
            'success' => true,
            'booking' => $booking
        ]);
    }
}
