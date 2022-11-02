{{--                                <a href="{{ route('generar_pdf_mesa', ['instancia' => $instancia->id]) }}" class="btn btn-info">DESCARGAR PDF</a>--}}
<div class="row text-center mx-2">
    @foreach($carreras as $carrera)
        <div class="col-sm-12 m-2 bg-info p-2 ">
            <b>{{$carrera['nombre']}}</b><br/>
            <i>{{$carrera['sede']}}</i> <br/>
            <a href="{{ route('generar_pdf_mesa', ['instancia' => $instancia, 'carrera'=>$carrera->id, 'llamado' => 1]) }}"
               class="btn">

                <i>1° llamado</i> <br/>
                <small style="font-size: 0.6em">DESCARGAR PDF</small>
            </a>
            <a href="{{ route('generar_pdf_mesa', ['instancia' => $instancia, 'carrera'=>$carrera->id, 'llamado' => 2]) }}"
               class="btn">
                <i>2° llamado</i> <br/>
                <small style="font-size: 0.6em">DESCARGAR PDF</small>
            </a>
        </div>
    @endforeach
</div>