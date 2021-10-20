<ul class="lista-ficha">
	<li><strong> Nombres: </strong> {{ $personal->nombres }}</li>
	<li><strong>Apellidos:</strong>  {{ $personal->apellidos }}</li>
	<li><strong>Sexo:</strong>  {{ ucwords($personal->sexo) }}</li>
	<li ><strong>D.N.I:</strong>  {{ $personal->dni }}</li>
	<li ><strong>CUIL:</strong>  {{ $personal->cuil }}</li>
	<li> <strong>Cargo:</strong>  {{ ucwords($personal->cargo) }}</li>
	<li> <strong>Título:</strong>  {{ $personal->titulo }}</li>
	<li> <strong>Teléfono:</strong>  {{ $personal->telefono }}</li>
	<li> <strong>Fecha de nacimiento:</strong>  {{ $personal->fecha }}</li>
	<li><strong>Sede: </strong> {{$personal->sede->nombre}}</li>
	<li> <strong>Estado:</strong>  
			<span class="{{ $personal->estado == 'activo' ? 'text-success' : 'text-danger' }}"> 
				{{ucwords($personal->estado)}} 
			</span>
	</li>
</ul>