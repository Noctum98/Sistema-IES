$(document).ready(function () {
    console.log($("#cargos"));
    $(".carreras-cargo").change(function (event) {
        $(".cargos").empty();
        console.log("Estoy en carrera");
        var idCarrera = event.target.value;
        var rutaCargos = "/selectCargosCarrera/" + idCarrera;
        console.log("Estoy con los cargos");
        $.get(rutaCargos, function (response, state) {
            if (response.length <= 0)
                $(".cargos").append("<option selected='selected' value=''>Cargos no encontradas</option>");
            else
                $(".cargos").append("<option selected='selected' value=''> - Seleccione el cargo - </option>");
            for (i = 0; i < response.length; i++) {
                $(".cargos").append("<option value='" + response[i].id + "'> [" + response[i].id + "] " + response[i].nombre + "</option>");
            }
        });
    });
});
