$(document).ready(function () {
    $(".estados").click(function(e){
        let id = $(this).data('id');
        $("#updateEstado"+id).submit();
    });

    $("#submitDerivar").click(function(e){
        $("#formDerivar").submit();
    });

    $("#derivacionGeneral").change(function(e){
        $("#sede_id").prop('disabled',false);
        if($(this).is(':checked'))
            {
                $("#sede_id").prop('disabled',true);
            }
    });

    $("#sede_id").change(function (event) {
        $("#carrera_id").empty();
        $("#carrera_id").prop('disabled',true);

        var idSede = event.target.value;
        
        rutaMaterias = "/sedes/selectCarreraSede/" + idSede;

        $.get(rutaMaterias, function (response, state) {

            $("#carrera_id").prop('disabled',false);
            if (response.length <= 0)
                $("#carrera_id").append("<option selected='selected' value=''>Carreras no encontradas</option>");
            else
                $("#carrera_id").append("<option selected='selected' value=''> - Seleccione la carrera - </option>");


            for (i = 0; i < response.length; i++) {

                $("#carrera_id").append("<option value='" + response[i].id + "'> [" + response[i].id + "] " + response[i].nombre + "</option>");
            }
        });
    });
});