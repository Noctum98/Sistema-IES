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
        'fst_sem',
        'snd_sem',
        'anual',
    ];

    public function crearCicloLectivo(int $cicloLectivo)
    {
        $primerSemestre = $cicloLectivo . '-07-31';
        $segundoSemestre = $anual = $cicloLectivo . '-11-30';
        return CicloLectivo::create([
            'id' => $cicloLectivo,
            'year' => $cicloLectivo,
            'fst_sem' => $primerSemestre,
            'snd_sem' => $segundoSemestre,
            'anual' => $anual,
        ]);
    }
}
