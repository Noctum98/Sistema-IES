$(document).ready(function () {

    var carrera_id = $(".carreras").val();
    var materia_selected = $("#materia_selected").val();

    if(carrera_id && materia_selected)
    {
        var rutaMaterias = "/selectMateriasCarrera/" + carrera_id;

        $.get(rutaMaterias, function (response, state) {
    
    
            if (response.length <= 0)
                $(".materias").append("<option selected='selected' value=''>Materias no encontradas</option>");
            else
                $(".materias").append("<option selected='selected' value=''> - Seleccione la materia - </option>");
    
    
            for (i = 0; i < response.length; i++) {

                if(response[i].id == materia_selected)
                {
                    $(".materias").append("<option value='" + response[i].id + "' selected='selected'> [" + response[i].id + "] " + response[i].nombre + "</option>");

                }else{
                    $(".materias").append("<option value='" + response[i].id + "'> [" + response[i].id + "] " + response[i].nombre + "</option>");

                }
    
            }
        });
    }
    
    $(".carreras").change(function (event) {
        $(".materias").empty();
        console.log("Estoy entrando");
        var idCarrera = event.target.value;
        
        rutaMaterias = "/selectMateriasCarrera/" + idCarrera;


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

    $(".btn-password").click(function(e){
        let user_id = $(this).attr('id');
        $("#spinner-"+user_id).removeClass('d-none');
        console.log($("#spinner-"+user_id));
        let ruta = '/usuarios/reestablecer_password/'+user_id;

        $.get(ruta, function (response, state) {
            if(response.status == 'success'){
                $("#spinner-"+user_id).addClass('d-none');
                $("#check-"+user_id).removeClass('d-none');
                $("#password_rees").html("La contraseña se ha restablecido a: <b>12345678</b>");

            }   
        });
    });

});