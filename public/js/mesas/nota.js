$(document).ready(function () {
    $(".ausente").click(function(e) {
        console.log("hola")
        let checked = $(this).is(':checked')
        var inscripcion_id = $(this).data('id');

        if(checked)
        {
            $("#escrito-"+inscripcion_id).val('A');
            $("#escrito-"+inscripcion_id).prop('readonly',true);
            $("#oral-"+inscripcion_id).val('A');
            $("#oral-"+inscripcion_id).prop('readonly',true);
        }else{
            $("#escrito-"+inscripcion_id).val('');
            $("#escrito-"+inscripcion_id).prop('readonly',false);
            $("#oral-"+inscripcion_id).val('');
            $("#oral-"+inscripcion_id).prop('readonly',false);
        }
    });
});

