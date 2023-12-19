$(document).ready(function () {
    $('.check-notes-btn').click(function (e) {
        e.preventDefault();

        let url = $(this).data('url'); // Obtén la URL desde el data attribute
        let trOneProceso = $(this).data('trone'); // Obtén la URL desde el data attribute
        let proceso = $(this).data('proceso');
        let spin = $('#spin-' + proceso);
        spin.removeClass('d-none')
        spin.addClass('d-block')

console.log(trOneProceso)
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                // Aquí actualizas el <tr> con la respuesta del servidor
                // Recuerda que necesitas tener un identificador único para seleccionar el correcto <tr>
                // Por ejemplo: $('#unique-tr-id').html(response);
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
