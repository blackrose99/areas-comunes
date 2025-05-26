<table class="table table-bordered table-striped" id="bookings-table">
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
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($bookings) && $bookings->count())
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
                @if (strtolower($booking->status) === 'pending')
                <button class="btn btn-success btn-sm approve-booking" data-id="{{ $booking->id }}" data-action="{{ url('/bookings/' . $booking->id . '/approve') }}">Aprobar</button>
                <button class="btn btn-danger btn-sm reject-booking" data-id="{{ $booking->id }}" data-action="{{ url('/bookings/' . $booking->id . '/reject') }}">Rechazar</button>
                @else
                <span class="text-muted">Ya procesada</span>
                @endif
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="9">No hay reservas disponibles.</td>
        </tr>
        @endif
    </tbody>
</table>

<div id="alert-container" class="alert-container"></div>