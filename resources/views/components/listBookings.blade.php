<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Residente</th>
            <th>Área</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Personas</th>
            <th>Comentarios</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bookings as $booking)
        <tr>
            <td>{{ $booking->id }}</td>
            <td>{{ $booking->resident->name }}</td>
            <td>{{ $booking->area->name }}</td>
            <td>{{ $booking->date }}</td>
            <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>
            <td>{{ $booking->attendees }}</td>
            <td>{{ $booking->comments ?? 'N/A' }}</td>
            <td>{{ ucfirst($booking->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>