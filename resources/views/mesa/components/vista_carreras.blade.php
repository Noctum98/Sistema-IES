{{--                                <a href="{{ route('generar_pdf_mesa', ['instancia' => $instancia->id]) }}" class="btn btn-info">DESCARGAR PDF</a>--}}
<div class="row text-center mx-2">
    @foreach($carreras as $carrera)
        <div class="col-sm-12 m-2 bg-info p-2 ">
            <a href="{{ route('generar_pdf_mesa', ['instancia' => $instancia, 'carrera'=>$carrera->id]) }}"
               class="btn">
                <b>{{$carrera['nombre']}}</b><br/>
                <i>{{$carrera['sede']}}</i> <br/>
                <small style="font-size: 0.6em">DESCARGAR PDF</small>
            </a>
        </div>
    @endforeach
</div>