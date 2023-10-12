$(document).ready(function() {
    let $select = $('select');
    $parent = $select.parent();

    $(".select2").select2({
        dropdownParent: $("#exampleModal"),
        width: "100%",
        placeholder: 'Seleccione una opción',
        allowClear:true,
    });

    $(".switchinstacierre").change(function(){
        var cierre = 0;

        if($(this).is(':checked'))
        {
            cierre = 1
        }

        let instancia_id = $(this).data('instancia_id');

        updateInstancia(instancia_id,cierre);
    });

    $("#sedes").change(function(){
        let sedes = $(this).val();
        console.log(sedes);
        getCarreras(sedes);
    });

    $("#sedes-edit").change(function(){
        let sedes = $(this).val();
        console.log(sedes);
        getCarreras(sedes,true);
    });

    $("#mesaGeneral").change(function(e){
        if($(this).is(':checked')){
            $("#sedes").attr('disabled',true);
            $("#carreras").attr('disabled',true);
        }else{
            $("#sedes").attr('disabled',false);
            $("#carreras").attr('disabled',false);
        }
    });

    $("#mesaGeneralEdit").change(function(e){
        if($(this).is(':checked')){
            $("#sedes-edit").attr('disabled',true);
            $("#carreras-edit").attr('disabled',true);
        }else{
            $("#sedes-edit").attr('disabled',false);
            $("#carreras-edit").attr('disabled',false);
        }
    });

    function getCarreras(sedes,edit = false)
    {
        let url = '/carreras/sedes';
        let data = {
            'sedes': sedes
        }

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            //dataType: "dataType",
            success: function (response) {
                if(edit)
                {
                    $("#carreras-edit").empty();
                }else{
                    $("#carreras").empty();
                }

                if(response.status == 'success')
                {
                    for (let index = 0; index < response.data.length; index++) {
                        let element = response.data[index];
                        if(element.id)
                        {
                            if(edit)
                            {
                                $("#carreras-edit").append("<option id='"+element.id+"' value='"+element.id+"'>"+element.nombre +' - '+element.resolucion+': '+element.sede.nombre+"</option>");
                            }else{
                                $("#carreras").append("<option id='"+element.id+"' value='"+element.id+"'>"+element.nombre +' - '+element.resolucion+': '+element.sede.nombre+"</option>");
                            }
                        }
                    }
                } 
            }
        });
    }

    function updateInstancia(instancia_id,cierre)
    {
        let url = '/mesas/cierre/'+cierre+'/'+instancia_id;
        $.get(url,function(response)
        {
            console.log(response);
        });
    }
});