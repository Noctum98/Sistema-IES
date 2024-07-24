<?php

namespace App\Observers;

use App\Models\Config\Audit;
use App\Models\MesaAlumno;
use Illuminate\Support\Facades\Auth;

class MesaAlumnoObserver
{
    /**
     * Handle the MesaAlumno "created" event.
     *
     * @param  \App\Models\MesaAlumno  $mesaAlumno
     * @return void
     */
    public function created(MesaAlumno $mesaAlumno)
    {
        $data_audit = [
            'table' => 'mesa_alumno',
            'model' => 'MesaAlumno',
            'table_id' => $mesaAlumno->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => 'CREATE',
            'table_created_at' => $mesaAlumno->created_at,
            'table_updated_at' => $mesaAlumno->updated_at,
        ];

        Audit::create($data_audit);
    }

    /**
     * Handle the MesaAlumno "updated" event.
     *
     * @param  \App\Models\MesaAlumno  $mesaAlumno
     * @return void
     */
    public function updated(MesaAlumno $mesaAlumno)
    {
        $data_audit = [
            'table' => 'mesa_alumno',
            'model' => 'MesaAlumno',
            'table_id' => $mesaAlumno->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => '',
            'table_created_at' => $mesaAlumno->created_at,
            'table_updated_at' => $mesaAlumno->updated_at,
        ];

        $cambios = $mesaAlumno->getDirty();

        foreach($cambios as $field => $valor){
            if($field != 'updated_at')
            {
                $data_audit['changes'] = $data_audit['changes'].$field.': '.$valor.' | ';
            }
        }

        Audit::create($data_audit);
    }

    /**
     * Handle the MesaAlumno "deleted" event.
     *
     * @param  \App\Models\MesaAlumno  $mesaAlumno
     * @return void
     */
    public function deleted(MesaAlumno $mesaAlumno)
    {
        //
    }

    /**
     * Handle the MesaAlumno "restored" event.
     *
     * @param  \App\Models\MesaAlumno  $mesaAlumno
     * @return void
     */
    public function restored(MesaAlumno $mesaAlumno)
    {
        //
    }

    /**
     * Handle the MesaAlumno "force deleted" event.
     *
     * @param  \App\Models\MesaAlumno  $mesaAlumno
     * @return void
     */
    public function forceDeleted(MesaAlumno $mesaAlumno)
    {
        //
    }
}
