$(document).ready(function () {
    // Configuración global del CSRF Token para todas las solicitudes AJAX
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    // Foco inicial en el campo de documento
    $("#document").focus();

    // Presionar Enter en campo de documento busca residente
    $("#document").keypress(function (e) {
        if (e.which === 13) {
            checkResident();
        }
    });

    // Mostrar formulario de login
    $("#btn_login").click(function () {
        $("#searchForm").hide();
        $("#div_login").show();
        $("#username").focus();
    });

    // Volver al formulario de búsqueda
    $("#btn_back_to_search").click(function () {
        $("#div_login").hide();
        $("#searchForm").show();
        $("#document").focus();
    });
    

    // Intento de inicio de sesión
    $("#loginBtn").click(function () {
        let email = $("#username").val();
        let password = $("#password").val();

        if (!email || !password) {
            alert("Por favor, completa todos los campos.");
            return;
        }

        $.ajax({
            url: "/login",
            method: "POST",
            data: {
                email: email,
                password: password
            },
            success: function (response) {
                alert("Bienvenido, " + response.user.name);
                $("#div_login").hide();
                $("#searchForm").hide();
                $("#bookingTableSection").show();
                updateBookingsList(); // Cargar reservas luego del login
            },
            error: function (xhr) {
                alert(xhr.responseJSON?.message || "Error al iniciar sesión.");
            }
        });
    });

    // Botón de verificación de residente
    $("#checkBtn").click(function () {
        checkResident();
    });

    // Cuando se cambia la fecha o área, buscar horarios disponibles
    $("#bookingDate, #commonArea").on("change", function () {
        buscarHorarios();
    });

    // Crear reserva
    $("#submitBooking").click(function () {
        let timeRange = $("#timeRange").val();

        if (!timeRange) {
            alert("Por favor, selecciona un horario.");
            return;
        }

        let [start_time, end_time] = timeRange.split(' - ');

        let data = {
            resident_id: $("#resident-id").val(),
            area_id: $("#commonArea").val(),
            date: $("#bookingDate").val(),
            start_time: start_time,
            end_time: end_time,
            comments: $("#comments").val(),
            attendees: $("#attendees").val()
        };

        fetch('/bookings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#bookingModal').modal('hide');
                    updateBookingsList();
                } else {
                    alert('Hubo un problema al crear la reserva.');
                }
            })
            .catch(error => {
                console.error('Error al crear reserva:', error);
            });
    });
});

// Verifica si el residente existe
function checkResident() {
    let documentNumber = $("#document").val().trim();

    if (!documentNumber) {
        alert("Por favor ingrese un número de documento.");
        return;
    }

    if ($("#document").data("processing")) {
        return;
    }

    $("#document").data("processing", true);
    $("#checkBtn").data("processing", true);

    $.post("/check-resident", { document: documentNumber })
        .done(function (response) {
            if (response.exists) {
                $('#login').hide();
                buscarAreas();
                mostrarInformacionUsuario(response.resident);
            } else {
                alert(response.message);
                $("#searchComponent").hide();
                $("#registro").show();
                $("#newDocument").val(documentNumber).focus();
            }
        })
        .fail(function (jqXHR) {
            let errorMessage = "Error al realizar la consulta.";
            if (jqXHR.responseJSON?.message) {
                errorMessage = jqXHR.responseJSON.message;
            }
            alert(errorMessage);
        })
        .always(function () {
            $("#document").data("processing", false);
            $("#checkBtn").data("processing", false);
        });
}

// Muestra info del residente autenticado
function mostrarInformacionUsuario(resident) {
    $("#resident-name").text(resident.name + " " + resident.last_name);
    $("#resident-document").text(resident.document);
    $("#resident-email").text(resident.email);
    $("#resident-phone").text(resident.phone || "No disponible");
    $("#resident-id").val(resident.id);

    const modalElement = document.getElementById("bookingModal");
    const bookingModal = new bootstrap.Modal(modalElement);
    bookingModal.show();
}

// Actualiza la lista de reservas
function updateBookingsList() {
    fetch('/bookings/list')
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar la lista de reservas.");
            return response.text();
        })
        .then(html => {
            const container = document.getElementById('bookings-list-container');
            container.innerHTML = html;
            container.style.display = 'block';
        })
        .catch(error => console.error("Error:", error));
}
