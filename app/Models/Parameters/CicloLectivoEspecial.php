<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicloLectivoEspecial extends Model
{
    use HasFactory;
    protected $table = 'ciclo_lectivo_especiales';
    protected $fillable = [
        'ciclo_lectivo_id',
        'cierre_ciclo',
        'materia_id',
    ];




}
