<style>
    sup {
        color: #dc3545;
    }
</style>
<form action="{{ route('ciclo_lectivo.update', ['ciclo_lectivo' => $cicloLectivo->id]) }}"
      method="POST">
    @csrf {{ method_field('PUT') }}

    <div class="form-group mb-3">
        <label> Ciclo lectivo {{$cicloLectivo->year}} </label>

    </div>
    <div class="form-group mb-3">
        <label for="fst_sem">Fecha regularidad 1<sup>er</sup> Semestre <sup>*</sup></label>
        <input type="date" name="fst_sem" id="fst_sem" class="form-control"
               value="{{date_format(new DateTime($cicloLectivo->fst_sem),'Y-m-d' )}}"
               required>
    </div>
    <div class="form-group mb-3">
        <label for="snd_sem">Fecha regularidad 2<sup>do</sup> Semestre <sup>*</sup></label>
        <input type="date" name="snd_sem" id="snd_sem" class="form-control"
               value="{{date_format(new DateTime($cicloLectivo->snd_sem),'Y-m-d' )}}"
               required>
    </div>
    <div class="form-group mb-3">
        <label for="anual">Fecha regularidad anual <sup>*</sup></label>
        <input type="date" name="anual" id="anual" class="form-control"
               value="{{date_format(new DateTime($cicloLectivo->anual),'Y-m-d' )}}"
               required>
    </div>


    <hr>
    <input name="ciclo_lectivo" id="ciclo_lectivo" type="hidden" value="{{$cicloLectivo->id}}"/>
    <sup>*</sup> <small>Campos requeridos</small><br/>
    <input type="submit" value="Guardar" class="btn btn-primary">
</form>
