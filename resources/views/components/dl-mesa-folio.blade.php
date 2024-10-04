@props([
    /** @var \App\Models\MesaFolio */
    'mesaFolio'
])

@if(session()->has('admin') || session()->has('regente'))
    <dt {{ $attributes->class(['text-lg-end col-lg-2 col-xl-3']) }}>ID</dt>
    <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->id }}</dd>
@endif
<dt class="text-lg-end col-lg-2 col-xl-3">Fecha</dt>
<dd class="col-lg-10 col-xl-9">{{ $mesaFolio->fecha }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Libro Digital</dt>
<dd class="col-lg-10 col-xl-9">
    {{ $mesaFolio->LibroDigital->romanos}} ({{$mesaFolio->LibroDigital->number}})
    @if(session()->has('admin'))
        <i>ID: {{$mesaFolio->LibroDigital->id}}</i>
    @endif
</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Master Materia</dt>
<dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->MasterMateria)->name }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Mesa</dt>
<dd class="col-lg-10 col-xl-9">
    @if(session()->has('admin'))
        {{optional($mesaFolio->mesa)->id}} <br/>
    @endif
    Fecha: {{ optional($mesaFolio->mesa)->fecha ? date_format(new DateTime( $mesaFolio->mesa->fecha ), 'd-m-Y') : '' }}
    <br/>
    Cierre: {{ optional($mesaFolio->mesa)->cierre ? date('d-m-Y', $mesaFolio->mesa->cierre) : ''}}
</dd>

<dt class="text-lg-end col-lg-2 col-xl-3">Turno</dt>
<dd class="col-lg-10 col-xl-9">{{ $mesaFolio->turno }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Folio</dt>
<dd class="col-lg-10 col-xl-9">{{ $mesaFolio->folio }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Presidente</dt>
<dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->presidente)->getApellidoNombre() }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Vocal 1</dt>
<dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->vocal1)->getApellidoNombre() }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Vocal 2</dt>
<dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->vacal2)->getApellidoNombre() }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Aprobados</dt>
<dd class="col-lg-10 col-xl-9">{{ $mesaFolio->aprobados }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Desaprobados</dt>
<dd class="col-lg-10 col-xl-9">{{ $mesaFolio->desaprobados }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Ausentes</dt>
<dd class="col-lg-10 col-xl-9">{{ $mesaFolio->ausentes }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Coordinador</dt>
<dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->coordinador)->getApellidoNombre() }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
<dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->operador)->getApellidoNombre() }}</dd>
<dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
<dd class="col-lg-10 col-xl-9">{{ $mesaFolio->created_at }}</dd>
@if($mesaFolio->created_at != $mesaFolio->updated_at)
    <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
    <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->updated_at }}</dd>
@endif
@if($mesaFolio->deleted_at)
    <dt class="text-lg-end col-lg-2 col-xl-3">Deleted At</dt>
    <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->deleted_at }}</dd>
@endif
