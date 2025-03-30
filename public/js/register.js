function registerResident() {
    let residentData = {
        name: $("#name").val(),
        last_name: $("#last_name").val(),
        document: $("#document").val(),
        document_type: $("#document_type").val(),
        email: $("#email").val(),
        phone: $("#phone").val(),
        address: $("#address").val(),
        birth_date: $("#birth_date").val(),
        status: "active"
    };

    $.post("/register-resident", residentData)
        .done(function (response) {
            alert(response.message);
            $("#registro").hide();
            $("#bookingModal").show();
            mostrarInformacionUsuario(response.resident);
        })
        .fail(function (xhr) {
            let errorMessage = xhr.responseJSON?.message || "Error al registrar el residente.";
            alert(errorMessage);
        });
}
