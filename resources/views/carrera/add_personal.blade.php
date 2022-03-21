@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
			Personal encargado de la carrera
		</h2>
		<p>Asigna los siguientes cargos para completar la creación de la carrera</p>
		<hr>
		<form method="POST" action="{{ route('agregar_personal',['id'=>$carrera->id]) }}">
			@csrf
			<div class="col-md-4">
				<div class="form-group">
					<label for="coordinador">Coordinador Disciplinar:</label>
					<select id="coordinador" name="coordinador" class="form-control">
						@foreach($personal as $persona)
							<option value="{{$persona->id}}">
								{{$persona->nombres.' '.$persona->apellidos}}
							</option>
						@endforeach
					</select>

					@error('coordinador')
						<span class="invalid-feedback d-block" role="alert">
				            <strong>{{ $message }}</strong>
				        </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="referente_p">Referente Pedagógico\a:</label>
					<select id="referente_p" name="referente_p" class="form-control">
						@foreach($personal as $persona)
							<option value="{{$persona->id}}">
								{{$persona->nombres.' '.$persona->apellidos}}
							</option>
						@endforeach
					</select>

					@error('referente_p')
						<span class="invalid-feedback d-block" role="alert">
				            <strong>{{ $message }}</strong>
				        </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="referente_s">Referente Social:</label>
					<select id="referente_s" name="referente_s" class="form-control">
						@foreach($personal as $persona)
							<option value="{{$persona->id}}">
								{{$persona->nombres.' '.$persona->apellidos}}
							</option>
						@endforeach
					</select>

					@error('referente_s')
						<span class="invalid-feedback d-block" role="alert">
				            <strong>{{ $message }}</strong>
				        </span>
					@enderror
				</div>
				<div class="form-group">
					<input type="submit" value="Asignar personal" class="btn btn-success">
				</div>
			</div>
		</form>
	</div>
@endsection