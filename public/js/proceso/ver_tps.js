$(document).ready(function () {
    setTimeout(function () {
        $(".modals").on("click", function (e) {
            e.preventDefault();
            $(".modal-body").html("");
            const id = $(this).attr('id').split('-');
            const proceso_id = id[2];

            let url = "/proceso/procesosCalificaciones/"+proceso_id;

            $.ajax({
                method: "GET",
                url: url,
                //dataType: "dataType",
                success: function (response) {
                    console.log(response);
                    $("#title_modal").html("Calificaciones: " + response[0].nombres + ' ' + response[0].apellidos);
                    $("#modalb-spin-"+proceso_id).addClass("d-none");
                    $("#modalh-spin-"+proceso_id).addClass("d-none");

                    response.forEach(trabajo => {
                        let color;
                        let porcentaje = '%';

                        if(trabajo.nota >= 6)
                        {
                            color = "badge-success";
                        }else{
                            color = "badge-danger";
                        }

                        if(trabajo.porcentaje == -1)
                        {
                            trabajo.porcentaje = 'A';
                            porcentaje = '';
                        }

                        $(".modal-body").append(
                            "<p><a href='/calificacion/create/"+trabajo.calificacion_id+"'>"+trabajo.nombre+"</a>: <span class='badge "+color+"'>"+trabajo.porcentaje+porcentaje+"</p>"
                        )
                    });
                }
            });
        })
    }, 3500)

});
