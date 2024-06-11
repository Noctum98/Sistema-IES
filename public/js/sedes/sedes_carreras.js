$(document).ready(function () {

    let rutaCarreras;
    const sedes = $("#sedes");
    // $("#sedes").select2({
    //     dropdownParent: $('#agregarModal'),
        // width: "100%"
    // });


    //
    // const carrera_selected = $("#carrera_selected").val();

    // if (sede_id && carrera_selected) {
    //     rutaCarreras = "/selectCarreraSede/" + sede_id;
    //
    //     $.get(rutaCarreras, function (response) {
    //
    //         if (response.length <= 0)
    //             $(".carreras").append("<option selected='selected' value=''>Carreras no encontradas</option>");
    //         else
    //             $(".carreras").append("<option selected='selected' value=''> - Seleccione la carrera - </option>");
    //
    //         for (let i = 0; i < response.length; i++) {
    //
    //             if (response[i].id === carrera_selected) {
    //                 $(".carreras").append("<option value='" + response[i].id + "' selected='selected'> [" + response[i].id + "] " + response[i].nombre + "</option>");
    //
    //             } else {
    //                 $(".carreras").append("<option value='" + response[i].id + "'> [" + response[i].id + "] " + response[i].nombre + "</option>");
    //
    //             }
    //
    //         }
    //     });
    // }

    $("#sedes").change(function (event) {
        const sede_id = sedes.val();
        $(".carreras").empty();

        const idSede = event.target.value;

        rutaCarreras = "/sedes/selectCarreraSede/" + idSede;

        $.get(rutaCarreras, function (response) {

            if (response.length <= 0)
                $(".carreras").append("<option selected='selected' value=''>Carreras no encontradas</option>");
            else
                $(".carreras").append("<option selected='selected' value=''> - Seleccione la carrera - </option>");

            for (let i = 0; i < response.length; i++) {
                $(".carreras").append("<option value='" + response[i].id + "'> [" + response[i].id + "] " + response[i].nombre + " (" + response[i].resolucion + ") " +  "</option>");
            }
        });
    });

});
