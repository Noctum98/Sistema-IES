<?php

namespace App\Observers;

use App\Models\CargoMateria;
use App\Models\Config\Audit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CargoMateriaObserver
{
    /**
     * Handle the CargoMateria "created" event.
     *
     * @param  \App\Models\CargoMateria  $cargoMateria
     * @return void
     */
    public function created(CargoMateria $cargoMateria)
    {
        $data_audit = [
            'table' => 'cargo_materia',
            'model' => 'CargoMateria',
            'table_id' => $cargoMateria->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => 'CREATE',
            'table_created_at' => $cargoMateria->created_at,
            'table_updated_at' => $cargoMateria->updated_at,
        ];

        Audit::create($data_audit);
    }

    /**
     * Handle the CargoMateria "updated" event.
     *
     * @param  \App\Models\CargoMateria  $cargoMateria
     * @return void
     */
    public function updated(CargoMateria $cargoMateria)
    {
        $data_audit = [
            'table' => 'cargo_materia',
            'model' => 'CargoMateria',
            'table_id' => $cargoMateria->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => '',
            'table_created_at' => $cargoMateria->created_at,
            'table_updated_at' => $cargoMateria->updated_at,
        ];

        $cambios = $cargoMateria->getDirty();

        foreach($cambios as $field => $valor){
            if($field != 'updated_at')
            {
                $data_audit['changes'] = $data_audit['changes'].$field.': '.$valor.' | ';
            }
        }

        Audit::create($data_audit);
    }

    /**
     * Handle the CargoMateria "deleted" event.
     *
     * @param  \App\Models\CargoMateria  $cargoMateria
     * @return void
     */
    public function deleted(CargoMateria $cargoMateria)
    {
        $data_audit = [
            'table' => 'cargo_materia',
            'model' => 'CargoMateria',
            'table_id' => $cargoMateria->id,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'changes' => 'DELETE',
            'table_created_at' => $cargoMateria->created_at,
            'table_updated_at' => $cargoMateria->updated_at,
            'table_deleted_at' => $cargoMateria->deleted_at ? $cargoMateria->deleted_at : Carbon::now()
        ];

        Audit::create($data_audit);
    }

    /**
     * Handle the CargoMateria "restored" event.
     *
     * @param  \App\Models\CargoMateria  $cargoMateria
     * @return void
     */
    public function restored(CargoMateria $cargoMateria)
    {
        //
    }

    /**
     * Handle the CargoMateria "force deleted" event.
     *
     * @param  \App\Models\CargoMateria  $cargoMateria
     * @return void
     */
    public function forceDeleted(CargoMateria $cargoMateria)
    {
        //
    }
}
