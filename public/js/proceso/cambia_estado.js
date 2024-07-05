$(document).ready(function () {

    $('.select-estado').on('change', function () {

        const campo = $(this);
        const proceso_id = campo.data('proceso_id');
        const proceso = campo.data('estado');

        const estado_id = campo.val();
        $('#span-' + proceso_id).removeClass('d-block')
        $('#span-' + proceso_id).addClass('d-none')
        $('#spin-' + proceso_id).removeClass('d-none')
        $('#spin-' + proceso_id).addClass('d-block')

        let url = '/proceso/cambia/estado';
        let data = {
            "proceso_id": proceso_id,
            "estado_id": estado_id
        };

        $.ajax({
            method: "POST",
            url: url,
            data: data,

            success: function (response) {
                if (response.errors) {
                    for (const key in response.errors) {
                        if (Object.hasOwnProperty.call(response.errors, key)) {
                            const element = response.errors[key];
                            $("#alerts").append("<div class='alert alert-danger'>" + element[0] + "</div>");
                            $([document.documentElement, document.body]).animate({
                                scrollTop: $("#container-scroll").offset().top
                            }, 100)
                        }
                    }
                } else {
                    $("#alerts").html("");
                    if (response.estado && $("#regularidad-" + proceso_id)) {
                        $("#regularidad-"+proceso_id).html(response.estado.regularidad);
                    }
                }

                if (response.estado && (response.estado.identificador == 5 || response.estado.identificador == 7)) {
                    $("#global-" + proceso_id).attr('disabled', false);
                    $("#observacion-" + proceso_id).removeClass('d-none');
                } else {
                    $("#global-" + proceso_id).attr('disabled', true);
                    $("#global-" + proceso_id).val('');

                    if (!$("#observacion-" + proceso_id).hasClass('d-none')) {
                        $("#observacion-" + proceso_id).addClass('d-none');
                    }
                }
            }
        });

        $('#span-' + proceso_id).removeClass('d-none')
        $('#span-' + proceso_id).addClass('d-block')
        $('#spin-' + proceso_id).removeClass('d-block')
        $('#spin-' + proceso_id).addClass('d-none')
    });
});
