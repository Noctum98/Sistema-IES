$(document).ready(function () {
    console.log('ff')
    $('.select-estado').on('change', function () {
        const campo = $(this);
        const proceso_id = campo.attr('id');
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
            //dataType: "dataType",
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

                    // $("#nota-" + proceso_id).attr('disabled', false);
                }

                if (response.estado && response.estado.identificador == 5) {
                    $("#global-" + proceso_id).attr('disabled', false);
                } else {
                    $("#global-" + proceso_id).attr('disabled', true);
                    $("#global-" + proceso_id).val('');
                }
            }
        });

        $('#span-' + proceso_id).removeClass('d-none')
        $('#span-' + proceso_id).addClass('d-block')
        $('#spin-' + proceso_id).removeClass('d-block')
        $('#spin-' + proceso_id).addClass('d-none')
        console.log($('#span-' + proceso_id))

    });
});