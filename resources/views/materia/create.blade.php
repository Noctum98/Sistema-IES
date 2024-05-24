@extends('layouts.app-prueba')
<link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/font-awesome/6.5.2/css/all.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/font-awesome/6.5.2/css/v4-shims.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/font-awesome/6.5.2/css/v5-font-face.min.css') }}" rel="stylesheet"/>
<link rel="stylesheet"
      href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css')}}"
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
@section('content')
    <div class="container p-3">
        <h2 class="h1 text-info">
            Crear materia para {{ $carrera->nombre }}
        </h2>
        <p>Asigna materias a la carrera</p>
        <hr>
        <div class="col-md-4">
            @if(@session('message'))
                <div class="alert alert-success">
                    {{ @session('message') }}
                </div>
            @endif
            <form method="POST" action="{{ route('crear_materia',['carrera_id'=>$carrera->id]) }}">
                @csrf
                <div class="form-group">

                    <label for="master_materia_id">Nombre:</label>
                    <select class="form-control select2" id="master_materia_id"
                            name="master_materia_id[]">
                        <option value="">Seleccione MasterMateria</option>
                        @foreach($masterMaterias as $master)

                            <option value="{{ $master->id }}">
                                {{ $master->name }}
                            </option>

                        @endforeach
                    </select>
                    @error('master_materia_id')
                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="regimen">Régimen:</label>
                    <select class="form-select" id="regimen" name="regimen">
                        <option value="">Seleccione Régimen</option>
                        <option value="Anual">Anual</option>
                        <option value="Cuatrimestral (1er)">Cuatrimestral (1er)</option>
                        <option value="Cuatrimestral (2do)">Cuatrimestral (2do)</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Guardar materia">
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')

    <script src="{{asset('vendors/select2/js/select2.min.js')}}"></script>
    <script src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(".select2").select2({
// dropdownParent: $('#agregaModal'),
                theme: "classic",
                width: "100%",
                placeholder: 'Seleccione una opción',
                allowClear: true
            });
        });
    </script>
@endsection
