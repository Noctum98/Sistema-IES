$(document).ready(function () {
    $(".llamado").click(function(event){
        let llamado = $(this).attr('id');

        console.log(llamado);

        $("#llamado").val(llamado);
    });
});