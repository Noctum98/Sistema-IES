$(document).ready(function () {

    console.log('cambia_cierre_cargo')

    $('.check-cierre').on('change', function () {
        const campo = $(this);
        const proceso_id = campo.attr('id');
        const proceso_cargo = campo.attr('data-cargo');
        const cierre = $(this).prop('checked');

        console.log(proceso_id)
        console.log(proceso_cargo)
        console.log(cierre)

        $('#span-' + proceso_id).removeClass('d-block')
        $('#span-' + proceso_id).addClass('d-none')
        $('#spin-' + proceso_id).removeClass('d-none')
        $('#spin-' + proceso_id).addClass('d-block')

        let url = '/proceso-modular/cambia/cierre_modular';
        let data = {
            "proceso_id": proceso_id,
            "cierre": cierre,
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


                        $('#' + proceso_id).attr('disabled', true);
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
                        $('#' + proceso_id).attr('disabled', false);
                    }


                }
                $('#span-' + proceso_id).removeClass('d-none')
                $('#span-' + proceso_id).addClass('d-block')
                $('#spin-' + proceso_id).removeClass('d-block')
                $('#spin-' + proceso_id).addClass('d-none')

                if ($('#nota-' + proceso_id).attr('disabled')) {
                    $('#nota-' + proceso_id).attr('disabled', false);
                } else {
                    $('#nota-' + proceso_id).attr('disabled', true);
                }

                console.log($('#span-' + proceso_id))


            }
        });

    });
});
