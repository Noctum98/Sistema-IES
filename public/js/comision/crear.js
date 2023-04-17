$(document).ready(function () {
    $("#unica").change(function(){
        if($(this).is(":checked"))
        {
            $("#nombre").prop('readonly',true);
            $("#nombre").val('Única');
        }else{
            $("#nombre").prop('readonly',false);
            $("#nombre").val('');
        }
    });
});