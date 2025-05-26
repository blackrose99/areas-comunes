<div class="card-form">
    <h2>Registrar Residente</h2>

    <div class="mb-2">
        <input type="text" id="name" class="form-control" placeholder="Nombre">
    </div>

    <div class="mb-2">
        <input type="text" id="last_name" class="form-control" placeholder="Apellido">
    </div>

    <div class="mb-2">
        <input type="text" id="document" class="form-control" placeholder="Documento">
    </div>

    <div class="mb-2">
        <select id="document_type" class="form-control">
            <option value="">Tipo de Documento</option>
            <option value="cc">Cédula de ciudadanía</option>
            <option value="ce">Cédula de extranjería</option>
            <option value="ti">Tarjeta de identidad</option>
            <option value="pp">Pasaporte</option>
        </select>
    </div>

    <div class="mb-2">
        <input type="email" id="email" class="form-control" placeholder="Correo">
    </div>

    <div class="mb-2">
        <input type="text" id="phone" class="form-control" placeholder="Teléfono">
    </div>

    <div class="mb-2">
        <input type="text" id="address" class="form-control" placeholder="Dirección">
    </div>

    <div class="mb-3">
        <input type="date" id="birth_date" class="form-control">
    </div>

    <button onclick="registerResident()" class="btn btn-custom w-100">
        Registrar
    </button>
</div>
