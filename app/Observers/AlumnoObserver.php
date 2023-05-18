<?php

namespace App\Observers;

use App\Models\Alumno;
use App\Models\Config\Audit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AlumnoObserver
{
    /**
     * Handle the Alumno "created" event.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return void
     */
    public function created(Alumno $alumno)
    {
        $data_audit = [
            'table' => 'alumnos',
            'model' => 'Alumno',
            'table_id' => $alumno->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => 'CREATE',
            'table_created_at' => $alumno->created_at,
            'table_updated_at' => $alumno->updated_at,
        ];

        Audit::create($data_audit);
    }

    /**
     * Handle the Alumno "updated" event.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return void
     */
    public function updated(Alumno $alumno)
    {
        $data_audit = [
            'table' => 'alumnos',
            'model' => 'Alumno',
            'table_id' => $alumno->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => '',
            'table_created_at' => $alumno->created_at,
            'table_updated_at' => $alumno->updated_at,
        ];

        $cambios = $alumno->getDirty();

        foreach($cambios as $field => $valor){
            if($field != 'updated_at')
            {
                $data_audit['changes'] = $data_audit['changes'].$field.': '.$valor.' | ';
            }
        }

        Audit::create($data_audit);
    }

    /**
     * Handle the Alumno "deleted" event.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return void
     */
    public function deleted(Alumno $alumno)
    {
        $data_audit = [
            'table' => 'alumnos',
            'model' => 'Alumno',
            'table_id' => $alumno->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => 'DELETE',
            'table_created_at' => $alumno->created_at,
            'table_updated_at' => $alumno->updated_at,
            'table_deleted_at' => $alumno->deleted_at ? $alumno->deleted_at : Carbon::now()
        ];

        Audit::create($data_audit);
    }

    /**
     * Handle the Alumno "restored" event.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return void
     */
    public function restored(Alumno $alumno)
    {
        //
    }

    /**
     * Handle the Alumno "force deleted" event.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return void
     */
    public function forceDeleted(Alumno $alumno)
    {
        //
    }
}
