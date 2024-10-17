@foreach($carreras as $carrera)
<div
    class="card-header bg-info text-dark d-flex justify-content-between align-items-center p-3 mt-3 my-2">
    <div class="col-sm-12 mx-1 px-5">
        <h4 class="card-title">
            Carrera: {{$carrera->resoluciones->name}}</h4>
        <h6 class="card-subtitle">
            Resolución N°: {{$carrera->resoluciones->resolution}}
        </h6>
    </div>
</div>
@endforeach
