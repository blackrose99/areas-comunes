<!-- resources/views/emails/booking_status.blade.php -->

<h2>Hola {{ $booking->resident->name ?? 'Residente' }},</h2>

<p>Tu reserva para el área <strong>{{ $booking->area->name }}</strong> el día <strong>{{ $booking->date }}</strong> ha sido:</p>

<h3>{{ strtoupper($booking->status) }}</h3>

<p>{{ $statusMessage }}</p>

<p>Gracias por usar nuestro sistema de reservas.</p>