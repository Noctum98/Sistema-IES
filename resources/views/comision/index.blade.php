@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
    <h2 class="h1 text-info">
        Comisiones de {{ $carrera->nombre }}
    </h2>
    <hr>
        <table class="table mt-4">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Año</th>
                    <th scope="col"> <i class="fa fa-cog" style="font-size:20px;"></i>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($comisiones as $comision)
                <tr style="cursor:pointer;">
                    <td>{{ $comision->nombre }}</td>
                    <td>
                       {{ $comision->año }}
                    </td>
                    <td>
                        <a href="{{ route('comisiones.show',$comision->id) }}" class="btn btn btn-secondary">Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endsection