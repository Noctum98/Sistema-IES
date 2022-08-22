$(document).ready(function () {
    console.log('ff')
    $('.check-cierre').on('change', function () {
        const campo = $(this);
        const proceso_id = campo.attr('id');
        const cierre = $(this).prop('checked');
        console.log(cierre)
        $('#span-' + proceso_id).removeClass('d-block')
        $('#span-' + proceso_id).addClass('d-none')
        $('#spin-' + proceso_id).removeClass('d-none')
        $('#spin-' + proceso_id).addClass('d-block')

        let url = '/proceso/cambia/cierre';
        let data = {
            "proceso_id": proceso_id,
            "cierre": cierre
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

                    if (response.cierre) {
                        $('#' + proceso_id).attr('disabled', true);
                    } else {
                        $('#' + proceso_id).attr('disabled', false);
                    }

                    if (response.estado_id == 5) {

                        if ($('#global-' + proceso_id).attr('disabled')) {
                            $('#global-' + proceso_id).attr('disabled', false);
                        } else {
                            $('#global-' + proceso_id).attr('disabled', true);
                        }


                        if ($('#btn-global-' + proceso_id).attr('disabled')) {
                            $('#btn-global-' + proceso_id).attr('disabled', false);
                        } else {
                            $('#btn-global-' + proceso_id).attr('disabled', true);
                        }
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