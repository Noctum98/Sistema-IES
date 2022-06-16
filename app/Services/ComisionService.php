<?php
namespace App\Services;

class ComisionService{

    public function hasProfesor($comision,$profesor_id)
    {
        if ($comision->profesores->where('id', $profesor_id)->first()) {
            return true;
        }
        return false;
    }

}