$(document).ready(function () {
 $("#datos-form").submit(function(e){
   e.preventDefault();
   let sede_id = $("#sede_id").val()?$("#sede_id").val(): 0;
   let carrera_id = $("#carrera_id").val()?$("#carrera_id").val(): 0;

   let edad = $("#edad").val() ?  $("#edad").val() : 0;
   let localidad = $("#localidad").val()? $("#localidad").val() :0;


   let url = '/estadistica/datos/';

   window.location.replace("/estadistica/datos/" + sede_id + "/"+carrera_id + '/' + localidad + '/' + edad);


 });

});