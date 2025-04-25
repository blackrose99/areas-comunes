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

    public function renderBookingsList()
    {
        $bookings = Booking::with(['resident', 'area'])->latest()->get();
        return view('components.listBookings', compact('bookings'));
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
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'comments' => 'nullable|string',
            'attendees' => 'required|integer|min:1|max:50',
        ]);


        // Agregar estado de la reserva
        $data['status'] = 'pending';

        // Crear la reserva
        $booking = Booking::create($data);

        // Responder con los datos de la reserva
        return response()->json([
            'success' => true,
            'booking' => $booking
        ]);
    }

    // BookingController.php
    public function showList()
    {
        $bookings = Booking::with(['resident', 'area'])->get();
        return view('bookings.listBookings', compact('bookings'));
    }







    /**
     * Obtener los rangos de horarios disponibles.
     */
    public function getTimeRanges(Request $request)
    {
        $date = $request->query('date');
        $areaId = $request->query('area_id');

        $horariosDisponibles = []; // Por ejemplo, ["08:00 - 09:00", "09:00 - 10:00", ...]
        $horaInicio = 8;
        $horaFin = 20;

        for ($h = $horaInicio; $h < $horaFin; $h++) {
            $inicio = sprintf('%02d:00', $h);
            $fin = sprintf('%02d:00', $h + 1);
            $horariosDisponibles[] = "$inicio - $fin";
        }

        // Aquí podrías filtrar horarios ocupados si lo deseas

        return response()->json($horariosDisponibles);
    }
}
