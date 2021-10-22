@extends('layouts.app')
@section('content')
	<div class="container">
		<h2 class="h1">
			Administrar instancias de mesas
		</h2>
		<hr>
		@if(Auth::user()->rol == 'rol_admin')
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
		  Crear Instancia
		</button>
		@endif
		@if(@session('mensaje'))
		<div class="alert alert-success mt-3">
			{{@session('mensaje')}}
		</div>
		@endif
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Crear Instancia</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form method="POST" action="{{route('crear_instancia')}}">
		        	@csrf
		        	<div class="form-group">
		        		<label for="nombre">Nombre</label>
		        		<input type="text" name="nombre" class="form-control" required>
		        	</div>
		        	<div class="form-group">
		        		<label for="nombre">Tipo</label>
		        		<select name="tipo" class="form-control">
		        			<option value="0">Común</option>
		        			<option value="1">Especial</option>
		        		</select>
		        	</div>
		        	<div class="form-group">
		        		<label for="limite">Limite</label>
		        		<input type="number" name="limite" class="form-control" required>
		        	</div>
		        	<input type="submit" class="btn btn-success" value="Crear">
		        </form>
		      </div>
		    </div>
		  </div>
		</div>
		@if(count($instancias) != 0)
		<table class="table mt-4">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Nombre</th>
		      <th scope="col">Tipo</th>
		      <th scope="col">Acción</th>
		      <th scope="col">Inactiva/Activa</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($instancias as $instancia)
		    <tr style="cursor:pointer;">
		      <td><b>{{ $instancia->nombre }}</b></td>
		      <td><b>{{ $instancia->tipo == 0 ? 'Común' : 'Especial' }}</b></td>
		      <td>
		      	<button type="button" class="btn-sm btn-secondary" data-toggle="modal" data-target="#modal{{$instancia->id}}">
				  Ver Inscripciones
				</button>
				@if(Auth::user()->rol == 'rol_admin')
				<button type="button" class="btn-sm btn-warning" data-toggle="modal" data-target="#edit{{$instancia->id}}">
				  Editar Mesa
				</button>
				<a href="{{route('borrar_datos',['id'=>$instancia->id])}}" type="button" class="btn-sm btn-danger" >
				  Borrar datos
				</a>
				@endif
		      </td>
		      <td>
		      	<div class="custom-control custom-switch">
				  <input type="checkbox" class="custom-control-input switchinsta" value="{{$instancia->estado}}" id="{{$instancia->id}}" 
				  {{$instancia->estado == 'activa' ? 'checked':''}}>
				  <label class="custom-control-label" for="{{$instancia->id}}"></label>
				</div>
		      </td>
		    </tr>
		    <!--Modal Ver-->
		    <div class="modal fade" id="modal{{$instancia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Elige la sede</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <form method="POST" action="{{route('sele.sede',['id'=>$instancia->id])}}">
			        	@csrf
			        	@foreach($sedes as $sede)
			        	<div class="form-check">
						  <input class="form-check-input" type="radio" name="sedes" id="radio{{$sede->id}}" value="{{$sede->id}}">
						  <label class="form-check-label" for="radio{{$sede->id}}">
						    {{$sede->nombre}}
						  </label>
						</div>
						@endforeach
						<br>
						<input type="submit" value="Ir a la sede" class="btn-sm btn-primary">
			        </form>
			      </div>
			    </div>
			  </div>
			</div>
			<!--Modal Editar-->
			<div class="modal fade" id="edit{{$instancia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Elige la sede</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <form method="POST" action="{{route('editar_instancia',['id'=>$instancia->id])}}">
			        	@csrf
			        	<div class="form-group">
			        		<label for="nombre">Nombre</label>
			        		<input type="text" name="nombre" class="form-control" value="{{$instancia->nombre}}" required>
			        	</div>
			        	<div class="form-group">
			        		<label for="nombre">Tipo</label>
			        		<select name="tipo" class="form-control">
			        			<option value="0" {{$instancia->tipo == 0 ? 'selected="selected"' : ''}}>Común</option>
			        			<option value="1" {{$instancia->tipo == 1 ? 'selected="selected"' : ''}}>Especial</option>
			        		</select>
			        	</div>
			        	<div class="form-group">
			        		<label for="limite">Limite</label>
			        		<input type="number" name="limite" class="form-control" value="{{$instancia->limite}}" required>
			        	</div>
			        	<input type="submit" class="btn btn-success" value="Editar">
			        </form>
			      </div>
			    </div>
			  </div>
			</div>
		    @endforeach
		  </tbody>
		</table>
		@else
		<p>No existen instancias creadas</p>
		@endif
	</div>
@endsection