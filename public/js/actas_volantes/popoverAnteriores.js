$(document).ready(function () {
    $('.popoverElement').on('click', function (event) {
        event.stopPropagation();

        var alumnoId = $(this).attr('data-alumno-id');
        var materiaId = $(this).attr('data-materia-id');

        // Inicializar popover aquí
        var popover = new bootstrap.Popover(this, {
            trigger: 'manual',
            title: 'Notas anteriores',
            content: 'Obteniendo...',
            html: true,
            // Asegurate de destruir el popover cuando pierda el foco
            animation: true,
            sanitize: false,
        });

        //Vinculamos el popover a nuestro elemento
        $(this).popover('show');

        fetch(`/actasVolantes/anteriores/${materiaId}/${alumnoId}`)
            .then(response => response.json())
            .then(data => {
                let result = '';
                data.forEach(item => {
                    result += `<p>${item.fecha} - ${item.nota}</p>`;
                });
                console.log(result)

                // Tomamos el popover del elemento y actualizamos su contenido
                popover.hide();// hide, in case that it is opening.
                popover.disable()

               let popover2 =  new bootstrap.Popover(this, {
                    trigger: 'manual',
                    title: 'Notas anteriores',
                    content: result,
                    html: true,
                    // Asegurate de destruir el popover cuando pierda el foco
                    animation: true,
                    sanitize: false,
                });
                popover2.show();
            })
            .catch((error) => {
                console.error('Error:', error);
            });


    });

    // Cerrar todos los popovers cuando se hace clic en cualquier lugar fuera del popover
    $('html').on('click', function() {
        $('.popoverElement').popover('hide');
    });
});
