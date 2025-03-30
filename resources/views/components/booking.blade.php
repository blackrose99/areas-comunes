<div class="modal" id="bookingModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Reservar Área Común</h2>

        <div id="resident-info">
            <p><strong>Nombre:</strong> <span id="resident-name"></span></p>
            <p><strong>Documento:</strong> <span id="resident-document"></span></p>
            <p><strong>Correo:</strong> <span id="resident-email"></span></p>
            <p><strong>Teléfono:</strong> <span id="resident-phone"></span></p>
        </div>

        <input type="hidden" id="resident-id">

        <select id="area">
            <option value="">--Seleccionar--</option>
        </select>
        <input type="time" id="time">
        <button onclick="createBooking()">Reservar</button>
    </div>
</div>