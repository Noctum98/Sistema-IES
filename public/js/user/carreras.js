$(document).ready(function () {

    console.log($("#carreras"));
    $(".carreras").change(function (event) {
        $(".materias").empty();
        console.log("Estoy entrando");
        var idCarrera = event.target.value;
        var rutaMaterias = "/selectMateriasCarrera/" + idCarrera;


        console.log("Estoy con los cargos");
        $.get(rutaMaterias, function (response, state) {


            if (response.length <= 0)
                $(".materias").append("<option selected='selected' value=''>Materias no encontradas</option>");
            else
                $(".materias").append("<option selected='selected' value=''> - Seleccione la materia - </option>");


            for (i = 0; i < response.length; i++) {

                    $(".materias").append("<option value='" + response[i].id + "'> [" + response[i].id + "] " + response[i].nombre + "</option>");



            }
        });
    });

});