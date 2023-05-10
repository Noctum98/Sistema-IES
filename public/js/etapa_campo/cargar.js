$(document).ready(function () {
    $(".modals-cargar").click(function () {
        let proceso_id = $(this).attr('id');
        let etapa_campo_id = $(this).data('campo');
        let habilitado = $(this).data('habilitado');
        $("#proceso_id").val(proceso_id);

        console.log(proceso_id, habilitado, etapa_campo_id);
        if (etapa_campo_id == null || etapa_campo_id == '') {
            $("#habilitado").prop('disabled', false);
            $("#submit_button").prop('disabled', false);
            console.log(habilitado);

            verificarHabilitacion(habilitado);

            $("#primera_evaluacion").val("");
            $("#segunda_evaluacion").val("");
            $("#tercera_evaluacion").val("");
            $("#asistencia").val("");
            $("#porcentaje_final").html("");



            $("#etapaCampoForm").attr({
                'action': '/etapa_campo',
                'method': 'POST'
            });

            $("#etapaCampoForm").append('<input type="hidden" name="_method" value="POST">');

            $("#habilitado").prop({
                'disabled': false
            });


            /*
            $("#primera_evaluacion").prop('disabled',false);
            $("#segunda_evaluacion").prop('disabled',false);
            $("#tercera_evaluacion").prop('disabled',false);
            $("#asistencia").prop('disabled',false);*/
        } else {
            console.log(habilitado);
           
            verificarHabilitacion(habilitado);

            buscarEtapaCampo(etapa_campo_id);
        }
    });

    $("#habilitado").click(function () {
        let proceso_id = $("#proceso_id").val();

        if ($(this).prop('checked')) {
            var habilitacion = 1;
        } else {
            var habilitacion = 0;
        }
        console.log("Habilitacion: " + habilitacion);
        let url = '/etapa_campo/habilitacion/proceso/' + proceso_id + '/' + habilitacion;
        console.log(url);
        $.get(url, function (response) {
            $("#" + proceso_id).attr('data-habilitado', response.habilitado_campo);
           
            if (response.habilitado_campo == "1" || response.habilitado_campo == 1) {

                $("#primera_evaluacion").prop('disabled', false);
                $("#segunda_evaluacion").prop('disabled', false);
                $("#tercera_evaluacion").prop('disabled', false);
                $("#asistencia").prop('disabled', false);

                $("#submit_button").prop('disabled', false);
            } else {
                $("#primera_evaluacion").prop('disabled', true);
                $("#segunda_evaluacion").prop('disabled', true);
                $("#tercera_evaluacion").prop('disabled', true);
                $("#asistencia").prop('disabled', true);
                $("#check-" + proceso_id).html("<i class='fas fa-times text-danger'></i>")
                $("#submit_button").prop('disabled', true);
            }
        })
    });
});

function buscarEtapaCampo(etapa_campo_id) {
    let url = '/etapa_campo/' + etapa_campo_id;

    $.get(url, function (response) {
        $("#habilitado").prop(
            'disabled', false
        );
        $("#primera_evaluacion").val(response.primera_evaluacion);
        $("#segunda_evaluacion").val(response.segunda_evaluacion);
        $("#tercera_evaluacion").val(response.tercera_evaluacion);
        $("#porcentaje_final").html("Porcentaje Final: " + response.porcentaje_final);


        $("#asistencia").val(response.asistencia);

        $("#etapaCampoForm").attr({
            'action': '/etapa_campo/' + response.id,
            'method': 'POST'
        });

        $("#etapaCampoForm").append('<input type="hidden" name="_method" value="PUT">');

    });
}

function verificarHabilitacion(habilitado)
{
    if (habilitado == 1) {
        
        $("#habilitado").prop('checked', true);
        $("#submit_button").prop('disabled', false);
        $("#primera_evaluacion").prop('disabled', false);
        $("#segunda_evaluacion").prop('disabled', false);
        $("#tercera_evaluacion").prop('disabled', false);
        $("#asistencia").prop('disabled', false);
    } else {
        $("#habilitado").prop('checked', false);
        $("#submit_button").prop('disabled', true);
        $("#primera_evaluacion").prop('disabled', true);
        $("#segunda_evaluacion").prop('disabled', true);
        $("#tercera_evaluacion").prop('disabled', true);
        $("#asistencia").prop('disabled', true);
    }
}