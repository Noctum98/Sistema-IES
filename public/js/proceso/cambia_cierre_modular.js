$(document).ready(function () {
    console.log('cambia_cierre_modular')
    $('.check-cierre').on('change', function () {
        const campo = $(this);
        const proceso_id = campo.attr('id');
        const proceso_tipo = campo.attr('data-tipo');
        const proceso_cargo = campo.attr('data-cargo');
        const cierre = $(this).prop('checked');
        const btn_comprueba = $('#btn_comprobar_'+proceso_id);
        let urlComprueba = btn_comprueba.attr('data-url'); // URL desde el data attribute
        let trOneProceso = btn_comprueba.data('trone');


        console.log(trOneProceso)

        $('#span-' + proceso_id).removeClass('d-block')
        $('#span-' + proceso_id).addClass('d-none')
        $('#spin-' + proceso_id).removeClass('d-none')
        $('#spin-' + proceso_id).addClass('d-block')

        let url = '/proceso/cambia/cierre';
        let data = {
            "proceso_id": proceso_id,
            "cierre": cierre,
            'tipo': proceso_tipo,
            'cargo': proceso_cargo
        };
        //
        //
        $.ajax({
            method: "POST",
            url: url,
            data: data,
            //dataType: "dataType",
            success: function (response) {
                if (response.errors) {
                    for (const key in response.errors) {
                        if (Object.hasOwnProperty.call(response.errors, key)) {
                            const element = response.errors[key];
                            $("#alerts").append("<div class='alert alert-danger'>" + element[0] + "</div>");
                        }
                    }
                } else {
                    $("#alerts").html("");

                    let coordinador = $("#coordinador").val();
                    if (response.cierre) {
                        if(coordinador == 0 || coordinador == "0")
                        {
                            campo.attr('disabled',true);
                        }


                        $('#select_' + proceso_id).attr('disabled', true);
                        $('#global-' + proceso_id).attr('disabled', true);
                            $('#btn-global-' + proceso_id).attr('disabled', true);

                    } else {
                        if (response.estado_id == 5) {
                            $('#global-' + proceso_id).attr('disabled', false);
                            $('#btn-global-' + proceso_id).attr('disabled', false);
                        }else{
                            $('#global-' + proceso_id).attr('disabled', true);
                            $('#btn-global-' + proceso_id).attr('disabled', true);
                        }
                        $('#select_' + proceso_id).attr('disabled', false);
                    }


                }


                if ($('#nota-' + proceso_id).attr('disabled')) {
                    $('#nota-' + proceso_id).attr('disabled', false);
                } else {
                    $('#nota-' + proceso_id).attr('disabled', true);
                }
                $.ajax({
                    url: urlComprueba,
                    type: "GET",
                    success: function (response) {
                        // Aquí actualizas el <tr> con la respuesta del servidor
                        // Se necesita tener un identificador único para seleccionar el correcto <tr>
                        // Por ejemplo: $('#unique-tr-id').html(response);
                        console.log('39')
                        $('#' + trOneProceso).html(response);

                    },
                    error: function(xhr, status, error) {

                    }

                });

                $('#span-' + proceso_id).removeClass('d-none')
                $('#span-' + proceso_id).addClass('d-block')
                $('#spin-' + proceso_id).removeClass('d-block')
                $('#spin-' + proceso_id).addClass('d-none')

                console.log($('#span-' + proceso_id))


            }
        });

    });
});
