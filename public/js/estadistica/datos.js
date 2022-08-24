$(document).ready(function () {
 $("#datos-form").submit(function(e){
   e.preventDefault();
   let sede_id = $("#sede_id").val();
   let edad = $("#edad").val();
   let localidad = $("#localidad").val();


   window.location.replace("/estadistica/datos/" + sede_id + "/"+edad + '/' + localidad);

 });

});