@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
    <a href="">
        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
    </a>
    <h2 class="h1 text-info">Registro de movimientos</h2>
    <hr>
    @foreach($modelos as $key => $modelo)
    <a type="button" href="{{ route('registros.show',$modelo) }}" class="list-group-item list-group-item-action border-top mt-2 text-secondary">
        <strong>
            {{ ucwords($key) }}
        </strong>
    </a>
    @endforeach
    </form>
</div>
@endsection