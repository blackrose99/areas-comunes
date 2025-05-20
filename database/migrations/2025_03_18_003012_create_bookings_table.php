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
            <th>Acciones</th> {{-- Nueva columna --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($bookings as $booking)
        <tr id="booking-{{ $booking->id }}">
            <td>{{ $booking->id }}</td>
            <td>{{ $booking->resident->name }}</td>
            <td>{{ $booking->area->name }}</td>
            <td>{{ $booking->date }}</td>
            <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>
            <td>{{ $booking->attendees }}</td>
            <td>{{ $booking->comments ?? 'N/A' }}</td>
            <td class="booking-status">{{ ucfirst($booking->status) }}</td>
            <td>
                <button class="btn btn-success btn-sm btn-approve" data-id="{{ $booking->id }}" title="Aprobar">
                    <i class="fas fa-check"></i>
                </button>
                <button class="btn btn-danger btn-sm btn-reject" data-id="{{ $booking->id }}" title="Rechazar">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>