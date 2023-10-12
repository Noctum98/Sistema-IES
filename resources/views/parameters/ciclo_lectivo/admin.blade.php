@extends('layouts.app-prueba')
@section('content')

        <h4 class="mt-4">Ciclos lectivos</h4>
        <hr>

        <div class="card mb-4">
            <div class="card-body">
                Listado de los ciclos lectivos con sus fechas de cierre.
                @if(Auth::user()->hasRole('admin'))
                    <a href="{{ route('ciclo-lectivo.create') }}" class="btn btn-sm btn-success ml-5">
                        Crear Ciclo Lectivo
                    </a>
                @endif
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Ciclos lectivos desde 1986
            </div>
            <div class="card-body row ">
                <table
                       class="table table-hover table-bordered table-striped table-responsive-xxl">
                    <thead>
                    <tr class="w-100">
                        <th scope="col">Año</th>
                        <th scope="col">Cierre 1<sup>er</sup> Semestre</th>
                        <th scope="col">Cierre 2<sup>do</sup> Semestre</th>
                        <th scope="col">Cierre Anual</th>
                        <th scope="col"><i class="fa fa-cogs"></i></th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach($ciclos as $ciclo)
                        <tr class="w-100">
                            <td scope="row">{{$ciclo->year}}</td>
                            <td>{{$ciclo->fst_sem}}</td>
                            <td>{{$ciclo->snd_sem}}</td>
                            <td>{{$ciclo->anual}}</td>
                            <td>Editar</td>

                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>


@endsection
