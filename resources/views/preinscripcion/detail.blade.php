@extends('layouts.app-prueba')
@section('content')
	<div class="container alumno">
		<h2 class="h1">
			Datos de {{ $alumno->nombres.' '.$alumno->apellidos }}
		</h2>
		<hr>
		<div class="col-md-12">
			<div class="row">
				<div class="datos-alumno">
					<ul>
						<li><strong>Nombre:</strong> {{ $alumno->nombres }}</li>
						<li><strong>Apellidos:</strong> {{ $alumno->apellidos }}</li>
						<li><strong>Edad:</strong> {{ $alumno->edad }} años</li>
						<li><strong>Telefono:</strong> {{ $alumno->telefono }}</li>
					</ul>
				</div>
			</div>
			<br>
			<div class="row">
				<ul class="datos-academicos">
					<li><h2>Datos Personales</h3></li>
					<li><strong>Email:</strong> {{ $alumno->email }}</li>
					<li><strong>Fecha de nacimiento: </strong> {{ $alumno->fecha }}</li>
					<li><strong>N° de documento: </strong> {{ $alumno->dni }}</li>
					<li><strong>CUIL:</strong> {{ $alumno->cuil }}</li>
					<li><strong>Nacionalidad:</strong> {{ ucwords($alumno->nacionalidad) }}</li>
					<li><strong>Residencia:</strong> {{ ucwords($alumno->residencia) }}</li>
					<li><strong>Domicilio:</strong> {{ $alumno->domicilio }}</li>
					<li><strong>Conexión a internet:</strong> {{ ucwords($alumno->conexion) }}</li>
					<li><strong>DNI:</strong>
					 	@if($alumno->dni_archivo)
							<a href="{{ route('descargar_archivo',['nombre'=>$alumno->dni_archivo,'alumno_dni']) }}" target="_blank">
								Ver archivo
							</a>
						@else
							No hay un archivo subido
						@endif
					</li>
					<li><strong>DNI (Archivo 2):</strong>
					 	@if($alumno->dni_archivo_2)
							<a href="{{ route('descargar_archivo',['nombre'=>$alumno->dni_archivo_2,'alumno_dni']) }}" target="_blank">
								Ver archivo
							</a>
						@else
							No hay un archivo subido
						@endif
					</li>
					<li><strong>Comprobante:</strong>
					 	@if($alumno->comprobante)
							<a href="{{ route('descargar_archivo',['nombre'=>$alumno->comprobante,'comprobante']) }}" target="_blank">
								Ver archivo
							</a>
						@else
							No hay un archivo subido
						@endif
					</li>
				</ul>
				<ul class="datos-academicos">
					<li><h2>Datos Académicos</h3></li>
					<li><strong>Carrera:</strong> {{ $alumno->carrera->nombre.' - '.$alumno->carrera->sede->nombre }}</li>
					<li><strong>Título secundario:</strong> 
						{{ ucwords($alumno->escolaridad) }}
					</li>
					<li><strong>Situación escolar</strong>
						{{ucwords($alumno->condicion_s)}}
					</li>
					<li><strong>Estudió en:</strong> {{ $alumno->escuela_s }}</li>
					<li><strong>Debe materias:</strong> {{ ucwords($alumno->materias_s) }}</li>
					<li>
						<strong>Certificado de nivel Secundario:</strong>
						@if($alumno->certificado_archivo)
							<a href="{{ route('descargar_archivo',['nombre'=>$alumno->certificado_archivo,'alumno_certificado']) }}" target="_blank">
								Ver archivo
							</a>
						@else
							No hay un archivo subido
						@endif
					</li>
					<li>
						<strong>Certificado de nivel Secundario (Archivo 2):</strong>
						@if($alumno->certificado_archivo_2)
							<a href="{{ route('descargar_archivo',['nombre'=>$alumno->certificado_archivo_2,'alumno_certificado']) }}" target="_blank">
								Ver archivo
							</a>
						@else
							No hay un archivo subido
						@endif
					</li>
					@if($alumno->primario)
					<li>
						<strong>Título Primario:</strong>
						<a href="{{ route('descargar_archivo',['nombre'=>$alumno->primario,'alumno_primario']) }}" target="_blank">
								Ver archivo
						</a>
					</li>
					@endif
					@if($alumno->curriculum)
					<li>
						<strong>Currículum:</strong>
						<a href="{{ route('descargar_archivo',['nombre'=>$alumno->curriculum,'alumno_curriculum']) }}" target="_blank">
								Ver archivo
						</a>
					</li>
					@endif
					@if($alumno->ctrabajo)
					<li>
						<strong>Certificado de trabajo:</strong>
						<a href="{{ route('descargar_archivo',['nombre'=>$alumno->ctrabajo,'alumno_ctrabajo']) }}" target="_blank">
								Ver archivo
						</a>
					</li>
					@endif
					@if($alumno->nota)
					<li>
						<strong>Nota:</strong>
						<a href="{{ route('descargar_archivo',['nombre'=>$alumno->nota,'alumno_nota']) }}" target="_blank">
								Ver archivo
						</a>
					</li>
					@endif
				</ul>
			</div>
			    @if(Auth::user())
			    @if($alumno->estado != 'verificado')
				<a href="{{route('pre_estado',['id'=>$alumno->id])}}" class="btn btn-primary">
					Marcar como verificado
				</a>
				@endif
				<a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
					Marcar como erróneo
				</a>
				<a href="{{route('pre.editar',['timecheck'=>$alumno->timecheck,'id'=>$alumno->id])}}" class="btn btn-warning" >
					Editar datos
				</a>
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-bs-labelledby="exampleModalLabel" aria-bs-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Indica el archivo erroneo</h5>
				        <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
				          <span aria-bs-hidden="true">&times;</span>
				        </button>
				      </div>
				      <form action="{{route('pre.error',['id'=>$alumno->id])}}" method="POST">
				      @csrf
				      <div class="modal-body">    		
				        <div class="form-check">
						  <input class="form-check-input" type="checkbox" value="DNI" id="dni_archivo" name="dni_archivo">
						  <label class="form-check-label" for="dni_archivo">
						    DNI
						  </label>
						</div>
						@if($alumno->dni_archivo_2)
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="DNI 2do archivo" id="dni_archivo_2" name="dni_archivo_2">
						  <label class="form-check-label" for="dni_archivo_2">
						    DNI (Archivo 2)
						  </label>
						</div>
						@endif
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="comprobante de pago" id="comprobante" name="comprobante">
						  <label class="form-check-label" for="comprobante">
						    Comprobante de pago
						  </label>
						</div>
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="certificado de nivel secundario" id="certificado_archivo" name="certificado_archivo">
						  <label class="form-check-label" for="certificado_archivo">
						    Cetificado de nivel secundario
						  </label>
						</div>
						@if($alumno->certificado_archivo_2)
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="certificado de nivel secundario 2do archivo" id="certificado_archivo_2" name="certificado_archivo_2">
						  <label class="form-check-label" for="certificado_archivo_2">
						    Cetificado de nivel secundario (Archivo 2)
						  </label>
						</div>
						@endif
						@if($alumno->primario)
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="título primario" id="primario" name="primario">
						  <label class="form-check-label" for="primario">
						    Título Primario
						  </label>
						</div>
						@endif
						@if($alumno->curriculum)
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="currículum" id="curriculum" name="curriculum">
						  <label class="form-check-label" for="curriculum">
						    Currículum
						  </label>
						</div>
						@endif
						@if($alumno->ctrabajo)
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="
						  certificado de trabajo" id="ctrabajo" name="ctrabajo">
						  <label class="form-check-label" for="ctrabajo">
						    Certificado de trabajo
						  </label>
						</div>
						@endif
						@if($alumno->nota)
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="nota al rector" id="nota" name="nota">
						  <label class="form-check-label" for="nota">
						    Nota al Rector
						  </label>
						</div>
						@endif
						<hr>
						<div class="form-group">
						    <label for="mensaje">Explicación (Opcional)</label>
						    <textarea class="form-control" name="mensaje"></textarea>
						</div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				        <input type="submit" value="Enviar email" class="btn btn-primary">
				      </div>
				      </form>
				    </div>
				  </div>
				  @endif
				</div>
		</div>
	</div>
@endsection