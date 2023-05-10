<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equivalencias extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'equivalencias';
    protected $fillable = ['alumno_id', 'materia_id', 'nota', 'fecha', 'resolution', 'user_id'];

    /**
     * @return null|string
     */
    public function nombreMateria(): ?string
    {
        $materia = Materia::where([
            'id' => $this->materia_id
        ])->first();

        return $materia->nombre;
    }
}
