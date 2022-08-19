$(document).ready(function () {
     $(".form_nota_global").each(function(){
        let proceso_id = $(this).attr('id');

        let url = "/proceso/calcularPorcentaje";
        let data = {
            "proceso_id": proceso_id
        }

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            //dataType: "dataType",
            success: function (response) {
                if(response.final_trabajos)
                {

                    if(response.final_trabajos >= 4){
                        var color = 'badge badge-success';
                    }else{
                        var color = 'badge badge-danger';
                    }

                    var plantilla_boton = "<div class='modals "+color+"' id='porcentaje-tps-"+proceso_id+"' data-bs-toggle='modal' data-bs-target='#tps-mostrar' style='cursor: pointer;'>"+response.final_trabajos;
                    $("#tp-"+proceso_id).html(plantilla_boton);

                    
                }else{
                    $("#tp-"+proceso_id).html("-");
                }
            }
        });
     });
    
    
});