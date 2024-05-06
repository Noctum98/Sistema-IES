<div class="card-header border-radius col-sm-12 flex-column">
    <div class="row text-center">
        <div class="col-sm-7 mx-auto">

            <h5 class="card-title">
                <small>Datos de la materia / módulo:</small> {{ $materia->nombre }}
            </h5>
        </div>
        <div class="col-sm-5 mx-auto">
            <h5 class="card-title">
                {{ $materia->carrera->nombre }}
            </h5>
            <p>
                {{$materia->carrera->sede->nombre}}
            </p>
        </div>
    </div>
</div>

<div class="card-body">

    <div class="row">

        <div class="col-sm-12">
            <div class="col-sm-3">
                <label for="nombre">Nombre:</label>
            </div>
            <div class="col-sm-9">
                {{ $materia->nombre }}
            </div>


            <div class="col-sm-3">
                <label for="año">Año:</label>
            </div>
            <div class="col-sm-9">

                {{ $materia->año }}
            </div>
            <div class="col-sm-3">
                <label for="regimen">Régimen: </label>
            </div>
            <div class="col-sm-9">
                {{ $materia->regimen}}

            </div>
            <div class="col-sm-3">
                <label for="cierre_diferido">Diferenciada</label>
            </div>
            <div class="col-sm-9">
                {{$materia->cierre_diferido}}
            </div>
            <div class="col-sm-3">
                <label for="etapa_campo">Etapa de Campo</label>
            </div>
            <div class="col-sm-9">

                {{ $materia->etapa_campo}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">

                <label for="correlativa_cursado">Correlatividades para cursar: </label>
            </div>
            <div class="col-sm-9">
                @foreach($materia->correlativasCursadoArray() as $correlativa)
                    {{$correlativa->nombre}} <br/>
                @endforeach

            </div>

            <div class="col-sm-3">

                <label for="correlativa">Correlatividades para rendir: </label>
            </div>
            <div class="col-sm-9">
                @foreach($materia->correlativasArray() as $mater)
                    {{ $mater->nombre }}<br/>
                @endforeach
            </div>
        </div>
        <div class="form-group mt-2">

            La materia tiene un cierre de ciclo lectivo distinto o un régimen distinto
            para la sede

            @if($materia->cierre_diferido)
                <div class="col-sm-12 text-center">
                    <h4>Cierres diferidos</h4>
                </div>
                <table class="table text-center">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th>
                            Ciclo Lectivo
                        </th>
                        <th>
                            Cierre ciclo
                        </th>
                        <th>
                            Régimen
                        </th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach($materia->ciclosLectivosDiferenciados() as $cicloLectivo )
                        <tr>
                            <td>
                                {{$cicloLectivo->ciclo_lectivo_id}}
                            </td>
                            <td>
                                {{date_format(new DateTime($cicloLectivo->cierre_ciclo),'d-m-Y')}}

                            </td>
                            <td>
                                {{$cicloLectivo->regimen}}
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            @endif


        </div>

    </div>
</div>
