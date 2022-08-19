$(document).ready(function () {
    $("#buscarDNI").click(function (e) {
        e.preventDefault();

        let dni = $("#dni").val();
        let carrera_id = $("#carrera_id").val();

        let url = '/alumnos/buscarAlumno/' + carrera_id;
        let data = {
            'busqueda': dni
        }

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            //dataType: "dataType",
            success: function (response) {

                if(response.status == 'success')
                {
                    let alumno = response.alumno;
                    $("#span-error").html("");
                    $("#alumno_id").html("<option value='"+alumno.id+"'>"+alumno.nombres + " " +alumno.apellidos+"</option>");
                }else{
                    $("#span-error").html(response.message)
                }
             
            }
        });
    });

    $("#recargar").click(function (e) {
        e.preventDefault();

        let materia_id = $("#materia_id").val();

        let url = '/alumnos/alumnosMateria/' + materia_id;

        $.ajax({
            method: "GET",
            url: url,
            //dataType: "dataType",
            success: function (response) {
                $("#alumno_id").html("");
                for (let index = 0; index < response.length; index++) {
                    let alumno = response[index];
                    console.log(response[index]);
                    $("#alumno_id").append("<option value='"+alumno.id+"'>"+alumno.apellidos.toUpperCase() + " " +alumno.nombres+"</option>");
                }
            }
        });
    });


});
