@extends('layouts.pdf')
<div class="pdf-ficha">
	<div class="container">
		<h2 class="h1">
			Ficha de {{ $personal->nombres.' '.$personal->apellidos }} - IES 9015
		</h2>
		<hr>
		<div class="col-md-8">
			<div class="d-flex flex-column">
				@include('includes.personal')
			</div>
		</div>
	</div>
</div>