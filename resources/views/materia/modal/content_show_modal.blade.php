<div class="card-header border-radius col-sm-12 flex-column">
    <div class="row text-center">
        <div class="col-sm-7 mx-auto">
            <h6 class="card-title">
                <small>Datos de la materia / módulo:</small> <br/>
                {{ $materia->nombre }}
            </h6>
        </div>
        <div class="col-sm-5 mx-auto">
            <h6 class="card-subtitle">
                {{ $materia->carrera->nombre }}
            </h6>
            <br/>
            <p>
                {{$materia->carrera->sede->nombre}}
            </p>
        </div>
    </div>
</div>

<div class="card-body">

    <div class="row">


        <div class="col-sm-3">
            <label for="año">Año:</label>
        </div>
        <div class="col-sm-9">
            {{ $materia->año }} año
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
            @include('componentes.general.boolean', ['data' => $materia->cierre_diferido] )
        </div>
        <div class="col-sm-3">
            <label for="etapa_campo">Etapa de Campo</label>
        </div>
        <div class="col-sm-9">
            @include('componentes.general.boolean', ['data' => $materia->etapa_campo] )
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 mx-auto text-left">

            <label for="correlativa_cursado"><u>Correlatividades para cursar</u>: </label>
        </div>
        <div class="col-sm-11 mx-auto">
            <ul>
                @foreach($materia->materiasCorrelativasCursado()->get() as $correlativa)
                    <li class="list-group-item">°
                        {{$correlativa->nombre}} </li>
                @endforeach
            </ul>

        </div>

        <div class="col-sm-10 mx-auto text-left">
            <label for="correlativa">
                <u>Correlatividades para rendir</u>:
            </label>
        </div>
        <div class="col-sm-11 mx-auto">
            <ul>
                @foreach($materia->materiasCorrelativas()->get() as $mater)
                    <li class="list-group-item"> ° {{ $mater->nombre }} </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="form-group mt-2">
        @if($materia->cierre_diferido)
        La materia tiene un cierre de ciclo lectivo distinto o un régimen distinto
        para la sede


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
