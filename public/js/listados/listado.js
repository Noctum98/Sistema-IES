$(document).ready(function () {
    $("#buscadorProfesores").submit(function(e){
        e.preventDefault();
        $("#busquedaProfesor").val()
        var url = '/usuarios/listado/profesor/'+ $("#busquedaProfesor").val();

        $(location).prop('href', url);
    })
});