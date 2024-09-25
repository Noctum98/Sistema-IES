$(document).ready(function () {
    $("#modalHistorialDerivaciones").click(function (e) {
        $("#listaDerivaciones").html("");
        let ticket = $(this).data('ticket');
        let url = '/derivaciones_tickets/' + ticket;

        $.get(url, function (response) {
            console.log(response);
            response.forEach(element => {
                let sede = "";
                let carrera = "";
                let asignaciones = "";
                let actual = "<h5 class='mb-1'>Antigua</h5>";
                let list = "<div class='list-group-item list-group-item-action flex-column align-items-start'>";
                var fechaCreacion = new Date(element.created_at); // Aquí deberías obtener la fecha creada

                var dia = fechaCreacion.getDate();
                var mes = fechaCreacion.getMonth() + 1;
                var año = fechaCreacion.getFullYear();

                var fechaFormateada = dia + '-' + mes + '-' + año;


                if (element.carrera) {
                    carrera = "<p class='mb-1'>Carrera destino: " + element.carrera.nombre + " - " + element.carrera.resolucion + "</p>";
                }

                if (element.sede) {
                    sede = "<p class='mb-1'>Sede destino: " + element.sede.nombre + "</p>";
                }

                if (element.activa) {
                    list = "<div class='list-group-item list-group-item-action flex-column align-items-start active'>";
                    actual = "<h5 class='mb-1'>Actual</h5>"
                }

                if (element.asignaciones.length > 0) {
                    asignaciones = 'Asignaciones: <br> <ul>';
                    element.asignaciones.forEach(element => {
                        if (element.responsable == 1) {
                            asignaciones = asignaciones + "<li>"+element.user.nombre+" "+element.user.apellido+" (RESPONSABLE)";
                        }else{
                            asignaciones = asignaciones + "<li>"+element.user.nombre+" "+element.user.apellido;
                        }
                    })
                    asignaciones = asignaciones + "</ul>";
                }



                let div = $(list +
                    "<div class='d-flex w-100 justify-content-between'>" +
                     actual +
                    "<small>" + fechaFormateada + "</small>" +
                    "</div>" +
                    "<p class='mb-1'>Derivado a: " + element.rol.descripcion +
                    "<p class='mb-1'>Derivado por: " + element.operador.nombre + " " + element.operador.apellido + "</p>" +
                    sede + carrera +asignaciones+
                    "</div>");
                $("#listaDerivaciones").append(div);
            });
        });
    });
});