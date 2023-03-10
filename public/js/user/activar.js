$(document).ready(function () {
    $(".desactivar").click(function(){
        let element_id = $(this).attr('id').split('-');
        let user_id = element_id[1];

        var ruta = "/usuarios/activarDesactivar/" + user_id;

        cambiarEstado(ruta);

    });

    $(".activar").click(function(){
        let element_id = $(this).attr('id').split('-');
        let user_id = element_id[1];

        var ruta = "/usuarios/activarDesactivar/" + user_id;

        cambiarEstado(ruta);

    });

    function cambiarEstado(ruta){
        $.get(ruta,function(response,stata){
            if(response.activo)
            {
                $("#desactivar-"+response.id).removeClass('d-none')
                $("#activar-"+response.id).addClass('d-none')

            }else{
                $("#activar-"+response.id).removeClass('d-none')
                $("#desactivar-"+response.id).addClass('d-none')

            }
        });
    }
});