<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Proceso;


class ProcesoService{
    public function inscribir($alumno_id,$materias){
        $data = [];
        $data['alumno_id'] = $alumno_id;

        foreach ($materias as $materia) {
            $data['materia_id'] = $materia;
            $data['estado'] = 'en curso';
            Proceso::create($data);
        }

    }
}