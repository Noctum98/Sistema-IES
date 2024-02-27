<?php

namespace App\Observers;

use App\Models\AlumnoCarrera;
use App\Models\Config\Audit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AlumnoCarreraObserver
{
    /**
     * Handle the AlumnoCarrera "created" event.
     *
     * @param  \App\Models\AlumnoCarrera  $alumnoCarrera
     * @return void
     */
    public function created(AlumnoCarrera $alumnoCarrera)
    {
        $data_audit = [
            'table' => 'alumno_carrera',
            'model' => 'AlumnoCarrera',
            'table_id' => $alumnoCarrera->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => 'CREATE',
            'table_created_at' => $alumnoCarrera->created_at,
            'table_updated_at' => $alumnoCarrera->updated_at,
        ];

        Audit::create($data_audit);
    }

    /**
     * Handle the AlumnoCarrera "updated" event.
     *
     * @param  \App\Models\AlumnoCarrera  $alumnoCarrera
     * @return void
     */
    public function updated(AlumnoCarrera $alumnoCarrera)
    {
        $data_audit = [
            'table' => 'alumno_carrera',
            'model' => 'AlumnoCarrera',
            'table_id' => $alumnoCarrera->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => '',
            'table_created_at' => $alumnoCarrera->created_at,
            'table_updated_at' => $alumnoCarrera->updated_at,
        ];

        $cambios = $alumnoCarrera->getDirty();

        foreach($cambios as $field => $valor){
            if($field != 'updated_at')
            {
                $data_audit['changes'] = $data_audit['changes'].$field.': '.$valor.' | ';
            }
        }

        Audit::create($data_audit);
    }

    /**
     * Handle the AlumnoCarrera "deleted" event.
     *
     * @param  \App\Models\AlumnoCarrera  $alumnoCarrera
     * @return void
     */
    public function deleted(AlumnoCarrera $alumnoCarrera)
    {
        $data_audit = [
            'table' => 'alumno_carrera',
            'model' => 'AlumnoCarrera',
            'table_id' => $alumnoCarrera->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => 'DELETE',
            'table_created_at' => $alumnoCarrera->created_at,
            'table_updated_at' => $alumnoCarrera->updated_at,
            'table_deleted_at' => $alumnoCarrera->deleted_at ? $alumnoCarrera->deleted_at : Carbon::now()
        ];

        Audit::create($data_audit);
    }

    /**
     * Handle the AlumnoCarrera "restored" event.
     *
     * @param  \App\Models\AlumnoCarrera  $alumnoCarrera
     * @return void
     */
    public function restored(AlumnoCarrera $alumnoCarrera)
    {
        //
    }

    /**
     * Handle the AlumnoCarrera "force deleted" event.
     *
     * @param  \App\Models\AlumnoCarrera  $alumnoCarrera
     * @return void
     */
    public function forceDeleted(AlumnoCarrera $alumnoCarrera)
    {
        //
    }
}
