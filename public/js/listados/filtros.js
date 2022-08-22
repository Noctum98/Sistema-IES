$(document).ready(function () {
    $("#filtros").click(function (e) { 
        if($("#form_filtros").hasClass("d-none")){
            $("#form_filtros").removeClass("d-none");
        }else{
            $("#form_filtros").addClass("d-none");
        }
    });
});