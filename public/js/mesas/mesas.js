$(document).ready(function () {
    var llamado = 0;
    $(".inputs").change(function () {
        const segundo = $(this).prop('checked');
        const mesa_id = $(this).val();
        if (segundo) {
            $("#segundo-" + mesa_id).append("<input type='hidden' name='segundo-" + mesa_id + "'  value='1'/>")
        } else {
            $("#segundo-" + mesa_id).html("");
        }
    });

    $(".button-modal").click(function (param) {
        llamado = $(this).attr('id');


        $('.readonly_' + llamado).attr('readonly', true);
        $('.writeonly_' + llamado).keyup(function (e) {
            let data = $(this).attr('id').split('-');
            let llamado = data[1];

            let folios = $(".readonly_" + llamado).get();

            for (let index = 1; index <= folios.length; index++) {
                let valor = parseInt($(this).val());
                if (valor && valor > 0 && valor != NaN) {
                    $("#folio-" + llamado + '-' + (index + 1)).val(valor + index);
                } else {
                    $("#folio-" + llamado + '-' + (index + 1)).val("");
                }
            }
        });
    });





    $('.btn-guardar').click(function (e) {
        e.preventDefault();

        let data = $(this).data('folio').split('-');
        let llamado = data[0];
        let orden = data[1];
        let comision_id = $(this).data('comision_id');

        let mesa_id = $(this).data('mesa_id');
        var spinner = "#spin-"+llamado;
        var check = "#check-" + llamado;

        if(comision_id)
        {
            spinner = spinner + '_' + comision_id;
            check = check + '_' + comision_id;
        }
        $(spinner).removeClass('d-none');

        if (!$(check).hasClass('d-none')) {
            $(check).addClass('d-none');
        }

        if(comision_id)
        {
            var libro = $("#libro-" + llamado+"_"+comision_id).val();
            var folios = $(".folios_"+llamado+"_"+comision_id).get();

        }else{
            var libro = $("#libro-" + llamado+"_"+comision_id).val();
            var folios = $(".folios_"+llamado+"_"+comision_id).get();
        }
        console.log(folios);

        

        let folios_array = [];

        for (let index = 1; index <= folios.length; index++) {
            if(!comision_id)
            {
                folios_array.push( $("#folio-" + llamado + '-' + index).val() +'-'+ index );
            }else{
                folios_array.push( $("#folio-" + llamado + '-' + index + '-' + comision_id).val() +'-'+ index );
            }
        }
        let data_json = {
            'numero': libro,
            'folios': folios_array,
            'orden': orden,
            'llamado': llamado,
            'mesa_id': mesa_id
        };

        console.log(data_json);
        
        let url = '/libros';

        $.ajax({
            method: "POST",
            url: url,
            data: data_json,
            success: function (response) {
                $(spinner).addClass('d-none');
                $(check).removeClass('d-none');
            }
        });
        
    })
});