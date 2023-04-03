$(document).ready(function () {
    $(".procesos").click(function(){
        let datos = $(this).attr('id').split('-');
        let proceso_id = datos[0];
        let alumno_id = datos[1];

        let url = '/proceso/eliminar/'+proceso_id+'/'+alumno_id;

        $("#spinner").removeClass('d-none');


        $.get(url,function(response){
            console.log(response);
            $("#spinner").addClass('d-none');
            $("#"+proceso_id).remove();

        });
    });
});