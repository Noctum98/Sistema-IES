@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
			Editar ficha de {{ $personal->nombres.' '.$personal->apellidos }}
		</h2>
		<p>Edita la ficha del personal.</p>
		<hr>
		<div class="col-md-8">
			@if(@session('message'))
				<div class="alert alert-success">
					{{ @session('message') }}
				</div>
			@endif
			<form method="POST" action="{{ route('editar_personal',['id'=>$personal->id]) }}">
				@csrf
				<div class="row">
					<div class="d-flex flex-column col-md-6">
						<div class="form-group">
							<label for="nombres">Nombres:</label>
							<input type="text" id="nombres" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ $personal->nombres }}" required />

							@error('nombres')
								<span class="invalid-feedback d-block" role="alert">
			                        <strong>{{ $message }}</strong>
			                    </span>
							@enderror
						</div>
						<div class="form-group">
							<label for="apellidos">Apellidos:</label>
							<input type="text" id="apellidos" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ $personal->apellidos }}" required />

							@error('apellidos')
								<span class="invalid-feedback d-block" role="alert">
			                        <strong>{{ $message }}</strong>
			                    </span>
							@enderror
						</div>
						<div class="form-group">
							<label for="sexo">Sexo:</label>
							<select id="sexo" name="sexo" class="form-control">
								<option value="{{$personal->sexo}}" selected="selected">
									{{ ucwords($personal->sexo) }}
								</option>
								<option value="{{ $personal->sexo == 'masculino' ? 'femenino' : 'masculino' }}">
									{{ $personal->sexo == 'masculino' ? 'Femenino' : 'Masculino' }}
								</option>
							</select>

							@error('sexo')
								<span class="invalid-feedback d-block" role="alert">
			                        <strong>{{ $message }}</strong>
			                    </span>
							@enderror
						</div>
						<div class="form-group">
							<label for="dni">D.N.I:</label>
							<input type="number" id="dni" name="dni" class="form-control @error('dni') is-invalid @enderror" value="{{ $personal->dni }}" required />

							@error('dni')
								<span class="invalid-feedback d-block" role="alert">
			                        <strong>{{ $message }}</strong>
			                    </span>
							@enderror
						</div>
						<div class="form-group">
							<label for="cuil">CUIL:</label>
							<input type="number" id="cuil" name="cuil" class="form-control @error('cuil') is-invalid @enderror" value="{{ $personal->cuil }}" required />

							@error('cuil')
								<span class="invalid-feedback d-block" role="alert">
			                        <strong>{{ $message }}</strong>
			                    </span>
							@enderror
						</div>
						<div class="form-group">
							<label for="sede">Sede:</label>
							<select id="sede" name="sede_id" class="form-control">
								@foreach($sedes as $sede)
									@if($sede->id == $personal->sede_id)
										<option value="{{ $sede->id }}"  selected="selected">{{ $sede->nombre }}</option>
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
							<input type="submit" value="Editar ficha" class="btn btn-success col-md-12">
						</div>
					</div>
					<div class="d-flex flex-column col-md-6">
						<div class="form-group">
							<label for="cargo">Cargo:</label>
							<select id="cargo" name="cargo" class="form-control">
								<option value="{{$personal->cargo}}">{{ucwords($personal->cargo)}}</option>
								<option value="profesor">Profesor</option>
								<option value="preceptor">Preceptor</option>
								<option value="secretario">Secretario</option>
							</select>

							@error('cargo')
								<span class="invalid-feedback d-block" role="alert">
			                        <strong>{{ $message }}</strong>
			                    </span>
							@enderror
						</div>
						<div class="form-group">
							<label for="titulo">Título:</label>
							<input type="text" id="titulo" name="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ $personal->titulo }}" required />

							@error('titulo')
								<span class="invalid-feedback d-block" role="alert">
			                        <strong>{{ $message }}</strong>
			                    </span>
							@enderror
						</div>
						<div class="form-group">
							<label for="telefono">Teléfono:</label>
							<input type="number" id="telefono" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ $personal->telefono }}" required />

							@error('telefono')
								<span class="invalid-feedback d-block" role="alert">
			                        <strong>{{ $message }}</strong>
			                    </span>
							@enderror
						</div>
						<div class="form-group">
							<label for="fecha">Fecha de Nacimiento:</label>
							<input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ $personal->fecha }}" required />

							@error('fecha')
								<span class="invalid-feedback d-block" role="alert">
			                        <strong>{{ $message }}</strong>
			                    </span>
							@enderror
						</div>
						<div class="form-group">
							<label for="estado">Estado:</label>
							<select id="estado" name="estado" class="form-control">
								<option value="{{$personal->estado}}" selected="selected">
									{{ ucwords($personal->estado) }}
								</option>
								<option value="{{ $personal->estado == 'activo' ? 'inactivo' : 'activo' }}">
									{{ $personal->estado == 'activo' ? 'Inactivo' : 'Activo' }}
								</option>
							</select>

							@error('estado')
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