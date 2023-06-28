<?php

namespace App\Services;

use App\Models\Carrera;

class CarreraService{

    public function modulares()
    {
        return Carrera::where('tipo','modular')
        ->orWhere('tipo','modular2')->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getCarrera(int $id): Carrera
    {
        return Carrera::find($id);
    }
}
