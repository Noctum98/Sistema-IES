$(document).ready(function () {
    $(".inputs").change(function(){
        const segundo = $(this).prop('checked');
        const mesa_id = $(this).val();
        if(segundo)
        {
            $("#segundo-"+mesa_id).append("<input type='hidden' name='segundo-"+mesa_id+"'  value='1'/>")
        }else{
            $("#segundo-"+mesa_id).html("");
        }
    });
});