$(document).ready(function () {
    $('.popoverElement').on('click', function (event) {
        event.stopPropagation();

        var alumnoId = $(this).attr('data-alumno-id');
        var materiaId = $(this).attr('data-materia-id');
        var cohorte = $("#cohorte").val();

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
        let result = '';
        fetch(`/actasVolantes/anteriores/${materiaId}/${alumnoId}/${cohorte}`)
            .then(response => response.json())
            .then(data => {

                console.log(data)
                if (data || Object.keys(data).length > 0){

                    if (!Array.isArray(data)) {
                        data = Object.values(data);
                    }

                    if(data.length) {

                        data.forEach(item => {
                            result += `<p>
                        <i class="fa fa-edit text-primary" style="font-size: 0.5em"></i>
                         ${item.nota}
                         <i class="fa fa-calendar-alt text-primary" style="font-size: 0.7em"></i>
                        ${item.fecha} </p>`;
                        });
                    }
                    else
                    {
                        result = `<p>No se encontraron actas anteriores</p>`
                    }
                    console.log(result)
                }else{
                   result = `<p>No se encontraron actas anteriores</p>`
                }



            })
            .catch((error) => {
                result = `<p>Error: ${error}</p>`
                console.error('Error:', error);
            })
            .finally(() =>{
                // Tomamos el popover del elemento y actualizamos su contenido
                popover.hide();// hide, in case that it is opening.
                popover.disable()

                let popover2 = new bootstrap.Popover(this, {
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

        ;


    });

    // Cerrar todos los popovers cuando se hace clic en cualquier lugar fuera del popover
    $('html').on('click', function() {
        $('.popoverElement').popover('hide');
        $('.popover').popover('hide');
    });
});
