$(document).ready(function () {

    let rutaCarreras;
    const sede_id = $(".sedes").val();
    const carrera_selected = $("#carrera_selected").val();

    if(sede_id && carrera_selected)
    {
        rutaCarreras = "/selectCarreraSede/" + sede_id;

        $.get(rutaCarreras, function (response, state) {

            if (response.length <= 0)
                $(".carreras").append("<option selected='selected' value=''>Carreras no encontradas</option>");
            else
                $(".carreras").append("<option selected='selected' value=''> - Seleccione la carrera - </option>");

            for (i = 0; i < response.length; i++) {

                if(response[i].id == materia_selected)
                {
                    $(".carreras").append("<option value='" + response[i].id + "' selected='selected'> [" + response[i].id + "] " + response[i].nombre + "</option>");

                }else{
                    $(".carreras").append("<option value='" + response[i].id + "'> [" + response[i].id + "] " + response[i].nombre + "</option>");

                }

            }
        });
    }

    $(".sedes").change(function (event) {
        $(".carreras").empty();

        const idSede = event.target.value;

        rutaCarreras = "/selectCarreraSede/" + idSede;



        $.get(rutaCarreras, function (response, state) {

            if (response.length <= 0)
                $(".carreras").append("<option selected='selected' value=''>Carreras no encontradas</option>");
            else
                $(".carreras").append("<option selected='selected' value=''> - Seleccione la carrera - </option>");


            for (i = 0; i < response.length; i++) {

                    $(".carreras").append("<option value='" + response[i].id + "'> [" + response[i].id + "] " + response[i].nombre + "</option>");

            }
        });
    });

});
