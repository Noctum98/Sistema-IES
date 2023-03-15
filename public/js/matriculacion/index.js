$(document).ready(function () {
    $("#link_matriculacion").click(function(e){
        e.preventDefault();
        let carrera_id = $(this).data('carrera');
        let alumno_id = $("#alumno_id").val();
        let año = $('input[name="año-'+carrera_id+'"]:checked').val();

        window.location.href = ("/matriculacion/editar/"+alumno_id+'/'+carrera_id+'/'+año);

        console.log(año);
    });
});