function buscarAreas() {
    $.get("/areas", function (areas) {
        llenarSelectorAreas(areas);
    }).fail(function () {
        alert("Error al cargar las áreas disponibles.");
    });
}


function llenarSelectorAreas(areas) {
    let select = $("#commonArea");
    select.empty();
    select.append('<option value="">--Seleccionar--</option>');
    areas.forEach(area => {
        select.append(`<option value="${area.id}">${area.name}</option>`);
    });
}

function buscarHorarios() {
    const fecha = $("#bookingDate").val();
    const areaId = $("#commonArea").val();

    if (!fecha || !areaId) {
        $("#timeRange").html('<option value="">Seleccione una fecha y un área primero</option>');
        return;
    }

    $.get("/time-ranges", { date: fecha, area_id: areaId })
        .done(function (horarios) {
            const select = $("#timeRange");
            select.empty();
            select.append('<option value="">Seleccione un horario</option>');
            horarios.forEach(hora => {
                select.append(`<option value="${hora}">${hora}</option>`);
            });
        })
        .fail(function () {
            alert("Error al obtener los horarios disponibles.");
        });
}



