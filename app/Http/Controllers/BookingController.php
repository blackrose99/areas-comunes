<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
    /*public function getBookings()
    {
        $bookings = Booking::with('resident', 'area')->get();
        return response()->json($bookings);
    }*/

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

        // Verificar si hay conflictos de horario
        $existingBooking = Booking::where('area_id', $data['area_id'])
            ->where('date', $data['date'])
            ->whereIn('status', ['pending', 'Confirmed'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                    ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                    ->orWhere(function ($q) use ($data) {
                        $q->where('start_time', '<=', $data['start_time'])
                            ->where('end_time', '>=', $data['end_time']);
                    });
            })
            ->exists();

        if ($existingBooking) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una reserva para esta área en el mismo horario.'
            ], 400);
        }

        // Agregar estado de la reserva
        $data['status'] = 'pending';

        // Crear la reserva
        $booking = Booking::create($data);

        // Responder con los datos de la reserva
        return response()->json([
            'success' => true,
            'message' => 'Reserva creada exitosamente.',
            'booking' => $booking
        ]);
    }

    /**
     * Obtener los rangos de horarios disponibles.
     */
    public function getTimeRanges(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'area_id' => 'required|exists:areas,id',
        ]);

        $date = $request->query('date');
        $areaId = $request->query('area_id');

        // Obtener reservas existentes para la fecha y área
        $existingBookings = Booking::where('area_id', $areaId)
            ->where('date', $date)
            ->whereIn('status', ['pending', 'Confirmed'])
            ->get(['start_time', 'end_time']);

        $horariosOcupados = [];
        foreach ($existingBookings as $booking) {
            $horariosOcupados[] = [
                'start' => $booking->start_time,
                'end' => $booking->end_time
            ];
        }

        $horariosDisponibles = [];
        $horaInicio = 8;
        $horaFin = 20;

        for ($h = $horaInicio; $h < $horaFin; $h++) {
            $inicio = sprintf('%02d:00', $h);
            $fin = sprintf('%02d:00', $h + 1);

            // Verificar si el rango está ocupado
            $isOccupied = false;
            foreach ($horariosOcupados as $ocupado) {
                if (
                    ($inicio >= $ocupado['start'] && $inicio < $ocupado['end']) ||
                    ($fin > $ocupado['start'] && $fin <= $ocupado['end']) ||
                    ($inicio <= $ocupado['start'] && $fin >= $ocupado['end'])
                ) {
                    $isOccupied = true;
                    break;
                }
            }

            if (!$isOccupied) {
                $horariosDisponibles[] = "$inicio - $fin";
            }
        }

        return response()->json($horariosDisponibles);
    }

    public function approveBooking(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            if (strtolower($booking->status) !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'La reserva ya ha sido procesada.'
                ], 400);
            }

            // Verificar conflictos de horario
            $existingBooking = Booking::where('area_id', $booking->area_id)
                ->where('date', $booking->date)
                ->where('id', '!=', $booking->id)
                ->whereIn('status', ['Confirmed'])
                ->where(function ($query) use ($booking) {
                    $query->whereBetween('start_time', [$booking->start_time, $booking->end_time])
                        ->orWhereBetween('end_time', [$booking->start_time, $booking->end_time])
                        ->orWhere(function ($q) use ($booking) {
                            $q->where('start_time', '<=', $booking->start_time)
                                ->where('end_time', '>=', $booking->end_time);
                        });
                })
                ->exists();

            if ($existingBooking) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede aprobar la reserva debido a un conflicto de horario.'
                ], 400);
            }

            $booking->status = 'Confirmed';
            $booking->save();

            // Enviar notificación por correo electrónico
            Mail::to($booking->resident->email)->send(new BookingStatusNotification($booking, 'Tu reserva ha sido aprobada.'));

            return response()->json([
                'success' => true,
                'message' => 'Reserva aprobada exitosamente.',
                'booking' => $booking
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rejectBooking(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            if (strtolower($booking->status) !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'La reserva ya ha sido procesada.'
                ], 400);
            }

            $booking->status = 'Cancelled';
            $booking->save();
            // Enviar notificación por correo electrónico
            Mail::to($booking->resident->email)->send(new BookingStatusNotification($booking, 'Tu reserva ha sido rechazada.'));

            return response()->json([
                'success' => true,
                'message' => 'Reserva rechazada exitosamente.',
                'booking' => $booking
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

}
class BookingStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $statusMessage;

    public function __construct($booking, $statusMessage)
    {
        $this->booking = $booking;
        $this->statusMessage = $statusMessage;
    }

    public function build()
    {
        return $this->subject('Estado de tu Reserva')
            ->view('emails.booking_status');
    }
}