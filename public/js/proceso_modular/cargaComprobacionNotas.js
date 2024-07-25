$(document).ready(function () {
    $('.check-notes-btn').click(function (e) {
        e.preventDefault();

        let url = $(this).data('url'); // URL desde el data attribute
        let trOneProceso = $(this).data('trone'); // URL desde el data attribute
        let proceso = $(this).data('proceso');
        let spin = $('#spin-' + proceso);
        spin.removeClass('d-none')
        spin.addClass('d-block')
        let data = {
            "proceso_id": proceso,
        };

        $.ajax({
            url: '/proceso/cambia/simular_cierre',
            type: "POST",
            data: data,
            success: function (response) {
                console.log('20')

                spin.removeClass('d-block')
                spin.addClass('d-none')
            },
            error: function(xhr, status, error) {
                // este bloque de código se ejecutará cuando ocurra un error
                spin.removeClass('d-block')
                spin.addClass('d-none')
            }

        });
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                // Aquí actualizas el <tr> con la respuesta del servidor
                // Se necesita tener un identificador único para seleccionar el correcto <tr>
                // Por ejemplo: $('#unique-tr-id').html(response);
                console.log('39')
                $('#' + trOneProceso).html(response);
                spin.removeClass('d-block')
                spin.addClass('d-none')
            },
            error: function(xhr, status, error) {
                // este bloque de código se ejecutará cuando ocurra un error
                spin.removeClass('d-block')
                spin.addClass('d-none')
            }

        });

    });
});
