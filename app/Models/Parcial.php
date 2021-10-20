<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcial extends Model
{
    use HasFactory;
    protected $table = 'parciales';

    public function parciales(){
        return $this->hasMany('App\Models\AlumnoParcial')->orderBy('nota','desc');
    }
}
