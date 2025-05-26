<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content booking-modal-content">
            <div class="modal-header header-blue">
                <h5 class="modal-title text-white" id="bookingModalLabel">Reservar Área Común</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Información del Residente</h6>
                <p><strong>Nombre:</strong> <span id="resident-name"></span></p>
                <p><strong>Documento:</strong> <span id="resident-document"></span></p>
                <p><strong>Email:</strong> <span id="resident-email"></span></p>
                <p><strong>Teléfono:</strong> <span id="resident-phone"></span></p>
                <input type="hidden" id="resident-id">

                <hr>
                <h6>Detalles de la Reserva</h6>
                <form id="bookingForm">
                    <div class="mb-3">
                        <label for="commonArea" class="form-label">Área Común</label>
                        <select class="form-select" id="commonArea" name="common_area" required>
                            <option value="">Seleccione un área común</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bookingDate" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="bookingDate" name="booking_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="attendees" class="form-label">Cantidad de Personas</label>
                        <input type="number" class="form-control" id="attendees" name="attendees" min="1" max="50" required>
                    </div>
                    <div class="mb-3">
                        <label for="comments" class="form-label">Comentarios</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Opcional... detalles adicionales de la reserva"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="timeRange" class="form-label">Rango de Hora</label>
                        <select class="form-select" id="timeRange" name="time_range" required>
                            <option value="">Seleccione un horario</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnclosebooking" class="btn btn-secondary">Cerrar</button>
                <button type="button" class="btn btn-primary" id="submitBooking">Reservar</button>
            </div>
        </div>
    </div>
</div>

