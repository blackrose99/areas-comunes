<div class="container p-4 rounded border border-primary shadow bg-white" style="max-width: 600px; margin: 20px auto;">
    <h2 class="text-primary fw-bold mb-4 text-center">Registrar Residente</h2>
    <form>
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" id="name" class="form-control" placeholder="Ingrese el nombre">
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Apellido</label>
            <input type="text" id="last_name" class="form-control" placeholder="Ingrese el apellido">
        </div>
        <div class="mb-3">
            <label for="document" class="form-label">Documento</label>
            <input type="text" id="document" class="form-control" placeholder="Ingrese el número de documento">
        </div>
        <div class="mb-3">
            <label for="document_type" class="form-label">Tipo de Documento</label>
            <input type="text" id="document_type" class="form-control" placeholder="Ingrese el tipo de documento">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" id="email" class="form-control" placeholder="Ingrese el correo electrónico">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" id="phone" class="form-control" placeholder="Ingrese el número de teléfono">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <input type="text" id="address" class="form-control" placeholder="Ingrese la dirección">
        </div>
        <div class="mb-3">
            <label for="birth_date" class="form-label">Fecha de Nacimiento</label>
            <input type="date" id="birth_date" class="form-control">
        </div>
        <button type="button" onclick="registerResident()" class="btn btn-primary w-100">
            <i class="fa fa-save"></i> Registrar
        </button>
    </form>
</div>