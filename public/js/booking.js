function buscarAreas() {
    $.get("/areas", function (areas) {
        llenarSelectorAreas(areas);
    }).fail(function () {
        alert("Error al cargar las áreas disponibles.");
    });
}


function llenarSelectorAreas(areas) {
    let select = $("#area");
    select.empty();
    select.append('<option value="">--Seleccionar--</option>');
    areas.forEach(area => {
        select.append(`<option value="${area.id}">${area.name}</option>`);
    });
}

function buscarHorarios() {

}

function hacerReservacion() {

}