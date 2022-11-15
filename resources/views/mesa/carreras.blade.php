@extends('layouts.app-prueba')

<link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet">

@section('content')
<div class="container">
	<h2 class="h1 text-info">
		{{$sede->nombre}}
	</h2>
	<hr>
	@if(@session('message'))
	<div class="alert alert-success">
		{{@session('message')}}
	</div>
	@endif
	@if(@session('message_edit'))
	<div class="alert alert-primary">
		{{@session('message_edit')}}
	</div>
	@endif
	@if(@session('error_fecha'))
	<div class="alert alert-danger">
		{{@session('error_fecha')}}
	</div>
	@endif

	@foreach($carreras as $carrera)
	<a type="button" href="{{ route('mesa.mesas',['id'=>$carrera->id,'instancia_id'=>$instancia->id]) }}" class="list-group-item list-group-item-action border-top mt-2 text-secondary" title="Ver calificaciones">
		<strong>
			{{ $carrera->nombre .'( '.ucwords($carrera->turno).' | Res: '.$carrera->resolucion.' )' }}
		</strong>
	</a>
	@endforeach
@endsection
@section('scripts')
<script src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script>

<script src="{{ asset('js/mesas/configuracion.js') }}"></script>
<script src="{{asset('vendors/select2/js/select2.min.js')}}"></script>
<script>
	$('.js-data-example-ajax').select2({

		ajax: {
			url: 'carrera/verProfesores/' + $(this).attr('id'),
			dataType: 'json'
			// Additional AJAX parameters go here; see the end of this chapter for the full code of this example
		}
	});
</script>

@endsection