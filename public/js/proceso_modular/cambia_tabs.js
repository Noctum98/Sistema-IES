$(document).ready(function(){
    $('#cargoTab a').on('click', function (event) {
        event.preventDefault();

        // Obtiene el ID del cargo de la pestaña clicada
        let cargoID = $(this).attr('href').replace('#cargo-', '');
        let materiaID = $(this).data('materia');
        let cicloLectivo = $(this).data('ciclo');

        // Aquí estás usando el ID del cargo para hacer una llamada AJAX al servidor y recuperar las notas
        $.ajax({
            url: '/proceso-modular/tabs_cargo/' + cargoID + '/' + materiaID + '/' + cicloLectivo,  // Actualiza esto a tu URL del servidor
            method: 'GET',
            success: function(data) {
                // Coloca las notas en el div apropiado
                $('#cargo-' + cargoID).html(data);

                // Aquí se activa la tab recién cargada
                $(event.target).tab('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
});
