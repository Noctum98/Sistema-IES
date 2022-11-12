<div class="row text-center mx-2">
    @foreach($mesas as $mesa)


        <div class="col-sm-12 m-2 bg-info p-2 ">
            <b>{{$mesa->materia($mesa->materia_id)->first()->nombre}}</b><br/>
            <i>{{$mesa->materia($mesa->materia_id)->first()->carrera()->first()->nombre}}</i> <br/>
            <i>{{optional($mesa->comision()->first())->nombre}}</i>

            <a href="{{ route('generar_pdf_acta_volante', ['instancia' => $instancia, 'carrera'=>$mesa->materia($mesa->materia_id)->first()->carrera()->first()->id,'materia' => $mesa->materia_id ,'llamado' => 1, 'comision' => optional($mesa->comision()->first())->id]) }}"

               class="btn">
                <i>1° llamado</i>
                <small style="font-size: 0.6em">Descargar Acta Volante</small>
            </a>

            <a href="{{ route('generar_pdf_acta_volante', ['instancia' => $instancia, 'carrera'=>$mesa->materia($mesa->materia_id)->first()->carrera()->first()->id,'materia' => $mesa->materia_id ,'llamado' => 2, 'comision' => optional($mesa->comision()->first())->id]) }}"

               class="btn">
                <i>2° llamado</i>
                <small style="font-size: 0.6em">Descargar Acta Volante</small>
            </a>
        </div>
    @endforeach
</div>