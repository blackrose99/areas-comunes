$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $("#document").focus();

    $("#document").keypress(function (e) {
        if (e.which == 13) {
            checkResident();
        }
    });

    $("#checkBtn").click(function () {
        checkResident();
    });
});

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
                $("#bookingModal").show();
                buscarAreas();
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
