<div class="col-md-7">

    @if(count($trianual->getDetalle()->get()) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Descripción</th>
                    <th scope="col">Nombre</th>
                    <th scope="col" class="text-center"><i class="fa fa-cogs"></i></th>
                </tr>
                </thead>
                <tbody>

                {{--                        Aqui @foreach() @endforeach--}}
                </tbody>
            </table>

        </div>

    @else
        <div class="col-sm-12">
        <h4 class="text-secondary text-center">No se han cargado materias en el trianual</h4>
        </div>
    @endif


</div>
