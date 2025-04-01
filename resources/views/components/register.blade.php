<div class="container p-4 rounded shadow" 
    style="max-width: 400px; background-color: #ffffff; border: 2px solid #004aad;">
    
    <h2 class="text-primary text-center mb-3" style="color: #004aad; font-weight: bold;">Registrar Residente</h2>

    <div class="mb-2">
        <input type="text" id="name" class="form-control border-primary" placeholder="Nombre"
            style="border-width: 2px; border-radius: 8px; font-size: 16px; background-color: #f8f9fa; color: #000;">
    </div>
    
    <div class="mb-2">
        <input type="text" id="last_name" class="form-control border-primary" placeholder="Apellido"
            style="border-width: 2px; border-radius: 8px; font-size: 16px; background-color: #f8f9fa; color: #000;">
    </div>

    <div class="mb-2">
        <input type="text" id="document" class="form-control border-primary" placeholder="Documento"
            style="border-width: 2px; border-radius: 8px; font-size: 16px; background-color: #f8f9fa; color: #000;">
    </div>

    <div class="mb-2">
        <input type="text" id="document_type" class="form-control border-primary" placeholder="Tipo de Documento"
            style="border-width: 2px; border-radius: 8px; font-size: 16px; background-color: #f8f9fa; color: #000;">
    </div>

    <div class="mb-2">
        <input type="email" id="email" class="form-control border-primary" placeholder="Correo"
            style="border-width: 2px; border-radius: 8px; font-size: 16px; background-color: #f8f9fa; color: #000;">
    </div>

    <div class="mb-2">
        <input type="text" id="phone" class="form-control border-primary" placeholder="Teléfono"
            style="border-width: 2px; border-radius: 8px; font-size: 16px; background-color: #f8f9fa; color: #000;">
    </div>

    <div class="mb-2">
        <input type="text" id="address" class="form-control border-primary" placeholder="Dirección"
            style="border-width: 2px; border-radius: 8px; font-size: 16px; background-color: #f8f9fa; color: #000;">
    </div>

    <div class="mb-3">
        <input type="date" id="birth_date" class="form-control border-primary"
            style="border-width: 2px; border-radius: 8px; font-size: 16px; background-color: #f8f9fa; color: #000;">
    </div>

    <button onclick="registerResident()" class="btn text-white w-100" 
        style="background-color: #004aad; border-radius: 8px; font-size: 16px;">
        Registrar
    </button>

</div>
