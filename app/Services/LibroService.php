<?php

namespace App\Services;

use App\Models\ActaVolante;
use App\Models\Libro;
use App\Models\Nota;

class LibroService
{

    public function __construct()
    {
    }


    /**
     * @param Libro $libro
     * @param bool $inscripciones
     * @return array
     *
     *
     * Esta función calcula el desglose de actas volantes en aprobadas, desaprobadas y ausentes para un Libro determinado.
     * Primero recupera la nota con la que se aprueba según el ciclo al que corresponda.
     * Luego, contabiliza las actas volantes con un promedio (promedio) mayor o igual a la nota aprobada (aprobado),
     * entre 0 y la nota aprobada (desaprobado), y con un promedio de -1 (ausente).
     *
     * La función devuelve una matriz con el recuento de actos volantes aprobados, desaprobados y ausentes.
     */
    public function getDesgloseAprobados(Libro $libro, bool $inscripciones = false): array
    {
        $desgloseAprobados = [];

        // Recuperar la nota con la que se aprueba para el ciclo del libro
        $notaAprobado = Nota::where('year', $libro->mesa->instancia->year_nota)
            ->where('min', '60')->first();

//        // Obtener todas las actas volantes para la mesa actual
        if ($inscripciones === true) {
            $libro->obtenerActasVolantesByMesaAlumno();
        } else {
            $libro->obtenerActasVolantes();
        }

//        Si hay actas volantes hago el desglose
        if (count($libro->actasVolantes) > 0) {

            // Contar las actas volantes con promedio >= nota aprobado
            // y agregarlo al desglose
            $desgloseAprobados['aprobados'] = ActaVolante::where(

                'promedio', '>=', (int)$notaAprobado->valor)
                ->where('libro_id', '=', $libro->id)
                ->count();

            // Contar las actas volantes con promedio entre 0 y la nota aprobada
            // y agregarlo al desglose
            $desgloseAprobados['desaprobados'] = ActaVolante::whereBetween(
                'promedio', [0, (int)$notaAprobado->valor - 1])
                ->where('libro_id', '=', $libro->id)
                ->count();

            // Contar las actas volantes con promedio = -1 (ausentes)
            // y agregarlo al desglose
            $desgloseAprobados['ausentes'] = ActaVolante::where(
                'promedio', '=', -1)
                ->where('libro_id', '=', $libro->id)
                ->count();

            $desgloseAprobados['total'] = $desgloseAprobados['aprobados'] + $desgloseAprobados['desaprobados'] + $desgloseAprobados['ausentes'];
        }

        return $desgloseAprobados;
    }
}
