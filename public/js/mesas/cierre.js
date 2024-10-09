$(document).ready(function () {
    $(".llamado").click(function(event){
        let llamado = $(this).attr('id');

        $("#llamado").val(llamado);
    });
});