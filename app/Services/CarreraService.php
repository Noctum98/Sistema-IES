<?php

namespace App\Services;

use App\Models\Carrera;

class CarreraService{

    public function modulares()
    {
        return Carrera::where('tipo','modular')
        ->orWhere('tipo','modular2')->get();
    }
}