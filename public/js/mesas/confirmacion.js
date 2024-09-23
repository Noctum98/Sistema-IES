$(document).ready(function () {
    var inscripcion_id = 0;
    var materia_id = 0;

    $('.inscripcion_id').click(function (e) {
        e.preventDefault();
        $("#datos").addClass('d-none');
        $("#inscripcion_id_modal").val()

        inscripcion_id = $(this).data('inscripcion_id');
        materia_id = $(this).data('materia_id');
        $("#lista_correlativas").html("");
        $("#lista_correlativas_folios").html("");
        $("#actas_incompletas").html("");
        $("#inscripcion_id_modal").val(inscripcion_id);


        let url = '/mesas/verificarInscripcion/' + inscripcion_id + '/' + materia_id;

        //let url = '/mesas/confirmar/'+inscripcion_id;

        $.ajax({
            method: "GET",
            url: url,
            //data: {},
            //dataType: "dataType",
            success: function (response) {


                if (!$("#cohorte").hasClass('d-none')) {
                    $("#cohorte").addClass('d-none')
                }

                if (response.mensaje_cohorte) {
                    if ($("#cohorte").hasClass('d-none')) {
                        $("#cohorte").removeClass('d-none')
                    }
                } else {
                    $("#datos").removeClass('d-none');
                    $("#nombre_alumno").html(response.inscripcion.nombres);
                    if (response.legajo_completo) {
                        $("#legajo").removeClass('alert-danger')
                        $("#legajo").addClass('alert-success')
                        $("#resultado_legajo").html("SI");
                    } else {
                        $("#legajo").removeClass('alert-success')
                        $("#legajo").addClass('alert-danger')
                        $("#resultado_legajo").html("NO");

                    }

                    if (response.regularidad) {
                        $("#regularidad").removeClass('alert-danger')
                        $("#regularidad").addClass('alert-success')
                        $("#resultado_regularidad").html("SI");
                        $("#proceso_p").removeClass('d-none');
                        if (response.proceso) {
                            $("#proceso").html(response.proceso.estado.nombre + ' | ' + response.proceso.ciclo_lectivo)

                        } else {
                            $("#proceso").html('-');
                        }
                    } else {
                        $("#regularidad").removeClass('alert-success')
                        $("#regularidad").addClass('alert-danger')
                        $("#resultado_regularidad").html("NO");
                        $("#proceso").html('-');
                    }

                    if (response.correlativas_incompletas.length == 0) {
                        $("#correlativas").removeClass('alert-danger')
                        $("#correlativas").addClass('alert-success')
                        $("#resultado_correlativas").html("SI");
                    } else {
                        $("#correlativas").removeClass('alert-success')
                        $("#correlativas").addClass('alert-danger')
                        $("#resultado_correlativas").html("NO");

                        response.correlativas_incompletas.forEach(element => {
                            $("#lista_correlativas").append('<li>' + element.nombre + '</li>')
                        });
                    }

                     let correlativas_folios = $("#correlativas_folios");

                    if (response.correlativas_incompletas_folios.length === 0) {
                        correlativas_folios.removeClass('alert-danger')
                        correlativas_folios.addClass('alert-success')
                        $("#resultado_correlativas_folios").html("SI");
                    } else {
                        correlativas_folios.removeClass('alert-success')
                        correlativas_folios.addClass('alert-danger')
                        $("#resultado_correlativas_folios").html("NO");

                        response.correlativas_incompletas_folios.forEach(element => {
                            $("#lista_correlativas_folios").append('<li>' + element.nombre + '</li>')
                        });
                    }

                    if (response.actas_incompletas.length == 0) {
                        $("#actas").removeClass('alert-danger')
                        $("#actas").addClass('alert-success')
                        $("#resultado_actas_incompletas").html("NO");
                    } else {
                        $("#actas").removeClass('alert-success')
                        $("#actas").addClass('alert-danger')
                        $("#resultado_actas_incompletas").html("SI");

                        response.actas_incompletas.forEach(element => {
                            $("#actas_incompletas").append('<li>' + convierteFecha(element.fecha) + ' ' + element.materia + '</li>')
                        });
                    }

                }


            }
        });
    });

    const convierteFecha = (fecha) => {
        return fecha.split('T')[0].split('-').reverse().join('/') + ' ' + fecha.split('T')[1];
    }

    $("#confirmarButton").click(function (e) {
        let inscripcion_id = $("#inscripcion_id_modal").val();
        let url = '/mesas/confirmar/' + inscripcion_id;


        $.ajax({
            method: "POST",
            url: url,
            data: {},
            //dataType: "dataType",
            success: function (response) {
                if (response.status == 'success') {
                    location.reload();
                }
            }
        });
    });
});
