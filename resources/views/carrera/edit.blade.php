@extends('layouts.app-prueba')
@section('content')
<div class="container p-2">
	<h2 class="h1">
		Editar carrera {{ $carrera->nombre }}
	</h2>
	<p>Edita los datos y personal encargado de la carrera</p>
	<hr>
	<div class="col-md-8">
		@if(@session('message'))
		<div class="alert alert-success">
			{{ @session('message') }}
		</div>
		@endif
		<form method="POST" action="{{ route('editar_carrera',['id'=>$carrera->id]) }}">
			@csrf
			<div class="row">
				<div class="d-flex flex-column col-md-6">
					<div class="form-group">
						<label for="nombre">Nombre de la carrera:</label>
						<input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ $carrera->nombre }}" required />

						@error('nombre')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="sede">Sede:</label>
						<select id="sede" name="sede_id" class="form-control">
							@foreach($sedes as $sede)
							@if($carrera->sede_id == $sede->id)
							<option value="{{ $sede->id }}" selected="selected">{{ $sede->nombre }}</option>
							@else
							<option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
							@endif

							@endforeach
						</select>

						@error('cargo')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="titulo">Nombre del título:</label>
						<input type="text" id="titulo" name="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ $carrera->titulo }}" required />

						@error('titulo')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="años">Años de duración:</label>
						<input type="number" id="años" name="años" class="form-control @error('años') is-invalid @enderror" value="{{ $carrera->años }}" required />

						@error('años')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="resolucion">Resolución:</label>
						<input type="text" id="resolucion" name="resolucion" class="form-control @error('resolucion') is-invalid @enderror" value="{{ $carrera->resolucion }}">

						@error('resolucion')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="vacunas">Vacunas:</label>
						<select class="form-control" name="vacunas" id="vacunas">
							<option value="todas" {{$carrera->vacunas == 'todas' ? 'selected="selected"':''}}>
								Todas
							</option>
							<option value="antitetánica" {{$carrera->vacunas == 'antitetánica' ? 'selected="selected"':''}}>
								Antitetánica
							</option>
							<option value="ninguna" {{$carrera->vacunas == 'ninguna' ? 'selected="selected"':''}}>
								Ninguna
							</option>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" value="Editar carrera" class="btn btn-success">
					</div>
				</div>
				<div class="d-flex flex-column col-md-6">
					<div class="form-group">
						<label for="modalidad">Modalidad:</label>
						<input type="text" id="modalidad" name="modalidad" class="form-control @error('modalidad') is-invalid @enderror" value="{{ $carrera->modalidad }}">

						@error('modalidad')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="tipo" >Tipo:</label>
						<select class="form-select" name="tipo" id="tipo">
							<option value="tradicional">Tradicional</option>
							<option value="tradicional2">Tradicional 70/30</option>
							<option value="modular">Modular</option>
							<option value="modular2">Modular 70/30</option>
						</select>
					</div>
					<div class="form-group">
						<label for="turno">Turno:</label>
						<select class="form-control" name="turno" id="turno">
							<option value="mañana" {{$carrera->turno == 'mañana' ? 'selected="selected"':''}}>
								Mañana
							</option>
							<option value="tarde" {{$carrera->turno == 'tarde' ? 'selected="selected"':''}}>
								Tarde
							</option>
							<option value="vespertino" {{$carrera->turno == 'vespertino' ? 'selected="selected"':''}}>
								Vespertino
							</option>
						</select>
					</div>
					<div class="form-group">
						<label for="turno">Estado:</label>
						<select class="form-control" name="estado" id="estado">
							<option value=null {{!$carrera->estado ? 'selected="selected"':''}}>
								En curso
							</option>
							<option value=1 {{$carrera->estado == 1 ? 'selected="selected"':''}}>
								En cierre
							</option>

						</select>
					</div>
					<div class="form-group">
						<label for="coordinador">Coordinador Disciplinar:</label>
						<select id="coordinador" name="coordinador" class="form-control">
							@if($carrera->coordinador == null || $carrera->coordinador == '')
							<option value=''>Ninguno</option>
							@endif
							@foreach($personal as $persona)
							@if($persona->id == $carrera->coordinador)
							<option value="{{$persona->id}}" selected="selected">
								{{$persona->nombres.' '.$persona->apellidos}}
							</option>
							@else
							<option value="{{$persona->id}}">
								{{$persona->nombres.' '.$persona->apellidos}}
							</option>
							@endif

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
							@if($carrera->referente_p == null || $carrera->referente_p == '')
							<option value=''>Ninguno</option>
							@endif
							@foreach($personal as $persona)
							@if($persona->id == $carrera->referente_p)
							<option value="{{$persona->id}}" selected="selected">
								{{$persona->nombres.' '.$persona->apellidos}}
							</option>
							@else
							<option value="{{$persona->id}}">
								{{$persona->nombres.' '.$persona->apellidos}}
							</option>
							@endif
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
							@if($carrera->referente_s == null || $carrera->referente_s == '')
							<option value=''>Ninguno</option>
							@endif
							@foreach($personal as $persona)
							@if($persona->id == $carrera->referente_s)
							<option value="{{$persona->id}}" selected="selected">
								{{$persona->nombres.' '.$persona->apellidos}}
							</option>
							@else
							<option value="{{$persona->id}}">
								{{$persona->nombres.' '.$persona->apellidos}}
							</option>
							@endif
							@endforeach
						</select>

						@error('referente_s')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection