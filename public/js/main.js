$(document).ready(function () {
    // Configuración global del CSRF Token para solicitudes jQuery
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
            showAlert('danger', 'Por favor, completa todos los campos.');
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
                if (response.success) {
                    $('meta[name="csrf-token"]').attr('content', response.csrf_token);
                    currentResident = response.user;
                    showAlert('success', "Bienvenido, " + response.user.name);
                    $("#div_login").hide();
                    $("#searchForm").hide();
                    $("#searchComponent").hide();
                    $("#bookingTableSection").show();
                    updateBookingsList();
                } else {
                    showAlert('danger', response.message || "Error al iniciar sesión.");
                }
            },
            error: function (xhr) {
                showAlert('danger', xhr.responseJSON?.message || "Error al iniciar sesión.");
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
            showAlert('danger', 'Por favor, selecciona un horario.');
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

        // Mostrar alerta de envío
        showAlert('info', 'Enviando solicitud de reserva...');

        fetch('/bookings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message || 'Reserva creada exitosamente.');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('danger', data.message || 'Hubo un problema al crear la reserva.');
                }
            })
            .catch(error => {
                console.error('Error al crear reserva:', error);
                showAlert('danger', 'Error al crear la reserva.');
            });
    });


    // Aprobar/Rechazar reservas
    $(document).on('click', '.approve-booking, .reject-booking', function () {
        const action = $(this).data('action');
        const bookingId = $(this).data('id');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        if (!csrfToken) {
            showAlert('danger', 'Error: Token CSRF no encontrado.');
            return;
        }

        fetch(action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({})
        })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('Error 419: Token CSRF no válido o sesión expirada.');
                    }
                    throw new Error(`HTTP error ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    $(`#booking-${bookingId} .booking-status`).text(data.booking.status);
                    $(`#booking-${bookingId} td:last-child`).html('<span class="text-muted">Ya procesada</span>');
                    showAlert('success', data.message);
                } else {
                    showAlert('danger', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', error.message);
            });
    });

    // Restaurar el formulario de búsqueda al cerrar el modal
    $('#bookingModal').on('hidden.bs.modal', function () {
        $("#searchComponent").show();
        $("#searchForm").show();
        $("#div_login").hide();
        $("#registro").hide();
        $("#bookingTableSection").hide();
        $("#document").val('').focus();
    });

    $('#btnclosebooking').on('click', function () {
        location.reload();
    });


});

// Variable global para almacenar los datos del residente
let currentResident = null;

function checkResident() {
    let documentNumber = $("#document").val().trim();

    if (!documentNumber) {
        showAlert('danger', 'Por favor ingrese un número de documento.');
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
                currentResident = response.resident;
                $('#login').hide();
                buscarAreas();
                mostrarInformacionUsuario(response.resident);
            } else {
                showAlert('danger', response.message);
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
            showAlert('danger', errorMessage);
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

    const modalElement = document.getElementById("bookingModal");
    const bookingModal = new bootstrap.Modal(modalElement);
    bookingModal.show();
}

function buscarHorarios() {
    const date = $("#bookingDate").val();
    const areaId = $("#commonArea").val();

    if (!date || !areaId) {
        $("#timeRange").empty();
        return;
    }

    fetch(`/time-ranges?date=${date}&area_id=${areaId}`)
        .then(response => response.json())
        .then(data => {
            $("#timeRange").empty().append('<option value="">Selecciona un horario</option>');
            data.forEach(time => {
                $("#timeRange").append(`<option value="${time}">${time}</option>`);
            });
        })
        .catch(error => {
            console.error('Error al cargar horarios:', error);
            showAlert('danger', 'Error al cargar horarios disponibles.');
        });
}

function showAlert(type, message) {
    const alertContainer = $('#alert-container');
    const alertClass = type === 'success' ? 'alert-success'
        : type === 'info' ? 'alert-info'
            : type === 'warning' ? 'alert-warning'
                : 'alert-danger';
    const alertId = 'alert-' + Date.now();
    const alertHtml = `
        <div id="${alertId}" class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    `;
    alertContainer.append(alertHtml);
    setTimeout(() => {
        $(`#${alertId}`).addClass('fade-out').on('animationend', function () {
            $(this).alert('close');
        });
    }, 3000);
}


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
            if ($.fn.DataTable.isDataTable('#bookings-table')) {
                $('#bookings-table').DataTable().destroy();
            }
            $('#bookings-table').DataTable({
                paging: true,
                searching: true,
                ordering: true
            });
        })
        .catch(error => {
            console.error("Error:", error);
            showAlert('danger', 'Error al cargar la lista de reservas.');
        });
}