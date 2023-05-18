<?php

namespace App\Observers;

use App\Models\Config\Audit;
use App\Models\Proceso;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProcesoObserver
{
    /**
     * Handle the Proceso "created" event.
     *
     * @param  \App\Models\Proceso  $proceso
     * @return void
     */
    public function created(Proceso $proceso)
    {
        $data_audit = [
            'table' => 'procesos',
            'model' => 'Proceso',
            'table_id' => $proceso->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => 'CREATE',
            'table_created_at' => $proceso->created_at,
            'table_updated_at' => $proceso->updated_at,
        ];

        Audit::create($data_audit);
    }

    /**
     * Handle the Proceso "updated" event.
     *
     * @param  \App\Models\Proceso  $proceso
     * @return void
     */
    public function updated(Proceso $proceso)
    {
        $data_audit = [
            'table' => 'procesos',
            'model' => 'Proceso',
            'table_id' => $proceso->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => '',
            'table_created_at' => $proceso->created_at,
            'table_updated_at' => $proceso->updated_at,
        ];

        $cambios = $proceso->getDirty();

        foreach($cambios as $field => $valor){
            if($field != 'updated_at')
            {
                $data_audit['changes'] = $data_audit['changes'].$field.': '.$valor.' | ';
            }
        }

        Audit::create($data_audit);
    }

    /**
     * Handle the Proceso "deleted" event.
     *
     * @param  \App\Models\Proceso  $proceso
     * @return void
     */
    public function deleted(Proceso $proceso)
    {
        $data_audit = [
            'table' => 'procesos',
            'model' => 'Proceso',
            'table_id' => $proceso->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => 'CREATE',
            'table_created_at' => $proceso->created_at,
            'table_updated_at' => $proceso->updated_at,
            'table_deleted_at' => $proceso->deleted_at ? $proceso->deleted_at : Carbon::now()
        ];

        Audit::create($data_audit);
    }

    /**
     * Handle the Proceso "restored" event.
     *
     * @param  \App\Models\Proceso  $proceso
     * @return void
     */
    public function restored(Proceso $proceso)
    {
        //
    }

    /**
     * Handle the Proceso "force deleted" event.
     *
     * @param  \App\Models\Proceso  $proceso
     * @return void
     */
    public function forceDeleted(Proceso $proceso)
    {
        //
    }
}
