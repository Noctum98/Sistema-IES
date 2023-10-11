<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicloLectivo extends Model
{
    use HasFactory;

    protected $table = 'ciclo_lectivos';
    protected $fillable = [
        'id',
        'year',
        '1st-sem',
        '2nd-sem',
        'anual',
    ];

    public function crearCicloLectivo(int $cicloLectivo)
    {
        $primerSemestre = $cicloLectivo . '-07-31';
        $segundoSemestre = $anual = $cicloLectivo . '-11-30';
        return CicloLectivo::create([
            'id' => $cicloLectivo,
            'year' => $cicloLectivo,
            '1st-sem' => $primerSemestre,
            '2nd-sem' => $segundoSemestre,
            'anual' => $anual,
        ]);
    }
}
