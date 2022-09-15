@extends('layouts.pdf')

<div class="container alumno">
    <img src="{{ 'images/logo-dge-iesvu.png' }}" style="width: 100%"  alt="DATA-IESVU">
    <h5><u> {{$carrera->nombre}} Res: {{$carrera->resolucion}}</u></h5>
    <h5><u>Turno: {{$instancia->nombre}}</u></h5>
    <h5><u>Mesas ordenadas por año</u> {{$carrera->sede()->first()->nombre}}</h5>

    <div class="col-md-12">

        <div class="datos-alumno">
            <ul class="col-md-6">
                <h3>Datos de Personales</h3>
                <li><strong>Nombre:</strong> {{ $instancia->nombre }}</li>
                {{--					<li><strong>Apellidos:</strong> {{ $alumno->apellidos }}</li>--}}
                {{--					<li><strong>Edad:</strong> {{ $alumno->edad }} años</li>--}}
                {{--					<li><strong>Telefono:</strong> {{ $alumno->telefono }}</li>--}}
                {{--					<li><strong>Email:</strong> {{ $alumno->email }}</li>--}}
                {{--					<li><strong>Fecha de nacimiento: </strong> {{ $alumno->fecha }}</li>--}}
                {{--					<li><strong>N° de documento: </strong> {{ $alumno->dni }}</li>--}}
                {{--					<li><strong>CUIL: </strong> {{ $alumno->cuil }}</li>--}}
                {{--					<li><strong>Género: </strong> {{ ucwords($alumno->genero) }}</li>--}}
            </ul>
        </div>


        {{--		<ul class="col-md-6">--}}
        {{--			<li>--}}
        {{--				<h2>Datos de Inscripción</h3>--}}
        {{--			</li>--}}
        {{--			<li><strong>Situación:</strong>{{ str_replace('_',' ',ucwords($alumno->regularidad)) }}</li>--}}
        {{--			<li>--}}
        {{--				<strong>Inscripto a:</strong>--}}
        {{--				<br>--}}
        {{--				@foreach($alumno->carreras as $carrera)--}}
        {{--				_ {{ $carrera->nombre.' ('.ucwords($carrera->turno).') - '.$carrera->sede->nombre }}--}}
        {{--				<br>--}}
        {{--				Año: {{ $alumno->procesoCarrera($carrera->id,$alumno->id)->año }}--}}
        {{--				@endforeach--}}
        {{--			</li>--}}
        {{--			<li> <strong>Materias:</strong>--}}
        {{--				<br>--}}
        {{--				@foreach($alumno->procesos as $proceso)--}}
        {{--				<p>{{$proceso->materia->nombre}}</p>--}}
        {{--				@endforeach--}}
        {{--			</li>--}}

        {{--			@if($alumno->año == 1)--}}
        {{--			<li><strong>Escuela Secundaria: </strong> {{ $alumno->escuela_s }}</li>--}}
        {{--			<li><strong>Articulo Séptimo: </strong> {{ $alumno->articulo_septimo ? 'Si' : 'No' }} </li>--}}
        {{--			<li><strong>Finalizo Escuela Secundaria: </strong> {{ $alumno->escolaridad ? 'Si' : 'No' }}</li>--}}
        {{--			<li><strong>Materias que adeuda de secundario: </strong>--}}
        {{--				@if(!$alumno->materias_s)--}}
        {{--				Ninguna--}}
        {{--				@else--}}
        {{--				{{ str_replace(';',' - ',$alumno->materias_s) }}--}}
        {{--				@endif--}}
        {{--			</li>--}}
        {{--			<li><strong>Presento título secundario:</strong> {{$alumno->titulo_s ? 'Si' : 'No'}} </li>--}}
        {{--			@endif--}}
        {{--		</ul>--}}


        {{--		<ul class="col-md-6">--}}
        {{--			<li>--}}
        {{--				<h2>Datos de Domicilio</h3>--}}
        {{--			</li>--}}
        {{--			<li><strong>Nacionalidad:</strong> {{ ucwords($alumno->nacionalidad) }}</li>--}}
        {{--			<li><strong>Provincia:</strong> {{ ucwords($alumno->provincia) }}</li>--}}
        {{--			<li><strong>Localidad:</strong> {{ ucwords($alumno->localidad) }}</li>--}}
        {{--			<li><strong>Calle: </strong> {{ $alumno->calle }}</li>--}}
        {{--			<li><strong>N° de calle: </strong> {{ $alumno->n_calle }}</li>--}}
        {{--			<li><strong>Barrio: </strong> {{ $alumno->barrio }}</li>--}}
        {{--			<li><strong>Manzana: </strong> {{ $alumno->manzana }} </li>--}}
        {{--			<li><strong>Casa: </strong> {{ $alumno->casa }}</li>--}}
        {{--			<li><strong>Código Postal: </strong> {{ $alumno->codigo_postal }}</li>--}}
        {{--		</ul>--}}

    </div>
</div>