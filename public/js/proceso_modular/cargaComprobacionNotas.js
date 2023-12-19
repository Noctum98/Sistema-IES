$(document).ready(function () {
    $('.check-notes-btn').click(function (e) {
        e.preventDefault();

        let url = $(this).data('url'); // Obtén la URL desde el data attribute
        let trOneProceso = $(this).data('trone'); // Obtén la URL desde el data attribute
console.log(trOneProceso)
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                // Aquí actualizas el <tr> con la respuesta del servidor
                // Recuerda que necesitas tener un identificador único para seleccionar el correcto <tr>
                // Por ejemplo: $('#unique-tr-id').html(response);
                $('#' + trOneProceso).html(response);
            }
        });

    });
});
