<div class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Reservar Área Común</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="resident-info" class="mb-3">
                    <p><strong>Nombre:</strong> <span id="resident-name"></span></p>
                    <p><strong>Documento:</strong> <span id="resident-document"></span></p>
                    <p><strong>Correo:</strong> <span id="resident-email"></span></p>
                    <p><strong>Teléfono:</strong> <span id="resident-phone"></span></p>
                </div>

                <input type="hidden" id="resident-id">

                <div class="mb-3">
                    <label for="area" class="form-label">Área</label>
                    <select id="area" class="form-select">
                        <option value="">--Seleccionar--</option>
                        <!-- Opciones dinámicas -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="time" class="form-label">Hora</label>
                    <input type="time" id="time" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="createBooking()">
                    <i class="fa fa-calendar-check"></i> Reservar
                </button>
            </div>
        </div>
    </div>
</div>