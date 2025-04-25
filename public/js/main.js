$(document).ready(function () {
    // Configuración de CSRF Token para solicitudes AJAX
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    // Foco inicial al campo de documento
    $("#document").focus();

    // Detecta si presionas Enter para verificar al residente
    $("#document").keypress(function (e) {
        if (e.which == 13) {
            checkResident();
        }
    });

    // Detecta si se hace clic en el botón de verificación
    $("#checkBtn").click(function () {
        checkResident();
    });

    // Cuando se cambia la fecha o el área común, busca horarios
    $("#bookingDate, #commonArea").on("change", function () {
        buscarHorarios();
    });

    // Manejo de la creación de una reserva
    $("#submitBooking").click(function () {
        let timeRange = document.getElementById('timeRange').value;

        // Asegúrate de que se haya seleccionado un horario
        if (timeRange) {
            // Divide el timeRange en start_time y end_time
            let [start_time, end_time] = timeRange.split(' - ');

            let data = {
                resident_id: document.getElementById('resident-id').value,
                area_id: document.getElementById('commonArea').value,
                date: document.getElementById('bookingDate').value,
                start_time: start_time,    // Asegúrate de que start_time se incluye
                end_time: end_time,        // Asegúrate de que end_time se incluye
                comments: document.getElementById('comments').value, // Obtén comentarios
                attendees: document.getElementById('attendees').value, // Obtén cantidad de personas
            };

            // Realiza la solicitud POST para crear la reserva
            fetch('/bookings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cierra el modal y actualiza la lista
                        $('#bookingModal').modal('hide');
                        updateBookingsList();
                    } else {
                        alert('Hubo un problema al crear la reserva.');
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            alert('Por favor, selecciona un horario.');
        }
    });
});

// Función para actualizar la lista de reservas
function updateBookingsList() {
    fetch('/bookings/list')
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar la lista de reservas.");
            return response.text();
        })
        .then(html => {
            const container = document.getElementById('bookings-list-container');
            container.innerHTML = html;
            container.style.display = 'block'; // Mostrar la tabla
        })
        .catch(error => console.error(error));
}

// Verificar si el residente existe o no
function checkResident() {
    let documentNumber = $("#document").val().trim();

    if (!documentNumber) {
        alertify.error("Por favor ingrese un número de documento.");
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

            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                errorMessage = jqXHR.responseJSON.message;
            }

            alert(errorMessage);
        })
        .always(function () {
            $("#document").data("processing", false);
            $("#checkBtn").data("processing", false);
        });
}

function mostrarInformacionUsuario(resident) {
    $("#resident-name").text(resident.name + " " + resident.last_name);
    $("#resident-document").text(resident.document);
    $("#resident-email").text(resident.email);
    $("#resident-phone").text(resident.phone || "No disponible");
    $("#resident-id").val(resident.id);

    let modalElement = document.getElementById("bookingModal");
    let bookingModal = new bootstrap.Modal(modalElement);
    bookingModal.show();
}
