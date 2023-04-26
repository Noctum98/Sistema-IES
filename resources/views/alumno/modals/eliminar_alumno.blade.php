<div class="modal fade" id="eliminarAlumnoModal{{$alumno->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Eliminar alumno
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    !ATENCIÓN! Al pulsar "Eliminar alumno" se borrará tanto el alumno, como los procesos y su notas en caso de tenerlas.
                </div>

                <a href="{{ route('alumno.delete',['id'=>$alumno->id]) }}" class="btn btn-danger">Eliminar Alumno</a>
            </div>

        </div>
    </div>
</div>