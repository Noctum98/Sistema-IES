<?php

namespace App\Services\Mesas;

use App\Models\ActaVolante;
use App\Models\FolioNota;
use App\Models\Materia;
use App\Models\MesaAlumno;
use App\Models\Nota;
use App\Models\Proceso;
use App\Repository\LibroDigital\FolioNotaRepository;

class MesaAlumnoService
{

    public function obtenerInscripciones($instancia_id, $materia_id, $estado_baja)
    {
        $inscripciones = MesaAlumno::where([
            'instancia_id' => $instancia_id,
            'materia_id' => $materia_id,
            'estado_baja' => $estado_baja
        ])->get();

        return $inscripciones;
    }

    public function condicionesRendir($mesa_alumno_id, $materia_id)
    {
        $mesa_alumno = MesaAlumno::find($mesa_alumno_id);
        $materia = Materia::find($materia_id);

        $data['legajo_completo'] = 0;
        $data['correlativas_incompletas'] = [];
        $data['actas_incompletas'] = [];
        $data['regularidad'] = 0;
        $data['inscripcion'] = $mesa_alumno;
        $inscripcionCarrera = $mesa_alumno->alumno->lastProcesoCarrera($materia->carrera_id);
        $regularidad_identificadores = [1, 3, 4, 7];

        if ($inscripcionCarrera->cohorte) {

            $procesoRegular = Proceso::where(['materia_id' => $materia->id, 'alumno_id' => $mesa_alumno->alumno_id])->where('ciclo_lectivo', '>=', $inscripcionCarrera->cohorte)->whereHas('estado', function ($query) use ($regularidad_identificadores) {
                return $query->whereIn('identificador', $regularidad_identificadores);
            })->with('estado')->first();


            if ($inscripcionCarrera->legajo_completo && $inscripcionCarrera->cohorte <= date('Y', strtotime($mesa_alumno->created_at))) {
                $data['legajo_completo'] = 1;
            }

            if ($procesoRegular) {
                $data['regularidad'] = 1;
                $data['proceso'] = $procesoRegular;
            }

            $mesa_fecha = $mesa_alumno->mesa ? date('Y', strtotime($mesa_alumno->mesa->fecha)) : date('Y', strtotime($mesa_alumno->created_at));

            $notas_aprobado = Nota::select('valor', 'year')->where('min', 60)->get();

            $correlativas = $materia->materiasCorrelativas;


            $data = $this->verifyCorrelativasByActaVolante($mesa_alumno, $correlativas, $mesa_fecha, $notas_aprobado, $data);
            $data = $this->verifyCorrelativasByFolioNota($mesa_alumno, $correlativas, $mesa_fecha, $notas_aprobado, $data);


        } else {
            $data['mensaje_cohorte'] = true;
        }


        return $data;
    }

    /**
     * @param $mesa_alumno
     * @param $correlativa
     * @param $mesa_fecha
     * @param $notas_aprobado
     * @param array $data
     * @return array
     */
    public function verifyCorrelativasByActaVolante($mesa_alumno, $correlativas, $mesa_fecha, $notas_aprobado, array $data): array
    {
        foreach ($correlativas as $correlativa) {
            $actas_volantes = ActaVolante::where(['alumno_id' => $mesa_alumno->alumno_id, 'materia_id' => $correlativa->id])->whereHas('inscripcionCarrera', function ($query) use ($mesa_fecha) {
                return $query->where('cohorte', '<=', $mesa_fecha);
            })->orderBy('created_at', 'DESC')
                ->get();

            if (count($actas_volantes) > 0) {
                foreach ($actas_volantes as $acta_volante) {
                    if ($acta_volante->inscripcion && $acta_volante->inscripcion->mesa && $acta_volante->inscripcion->mesa->instancia) {
                        $nota_aprobado = $notas_aprobado->where('year', $acta_volante->inscripcion->mesa->instancia->year_nota)->first();

                        if ($acta_volante->promedio >= $nota_aprobado->valor) {
                            if (in_array($correlativa, $data['correlativas_incompletas'])) {
                                $data['correlativas_incompletas'] = array_diff($data['correlativas_incompletas'], [$correlativa]);
                            }
                            break;
                        }

                        if ($acta_volante->promedio < $nota_aprobado->valor) {
                            if (!in_array($correlativa, $data['correlativas_incompletas'])) {
                                array_push($data['correlativas_incompletas'], $correlativa);
                            }
                        }

                    }
                }
            } else {
                if (!in_array($correlativa, $data['correlativas_incompletas'])) {
                    array_push($data['correlativas_incompletas'], $correlativa);
                }
            }
        }
        return $data;
    }


    /**
     * @param $mesa_alumno
     * @param $correlativas
     * @param $mesa_fecha
     * @param $notas_aprobado
     * @param array $data
     * @return array
     */
    public function verifyCorrelativasByFolioNota($mesa_alumno, $correlativas, $mesa_fecha, $notas_aprobado, array $data): array
    {

        foreach ($correlativas as $correlativa) {
            $actas_volantes = ActaVolante::where(['alumno_id' => $mesa_alumno->alumno_id, 'materia_id' => $correlativa->id])->whereHas('inscripcionCarrera', function ($query) use ($mesa_fecha) {
                return $query->where('cohorte', '<=', $mesa_fecha);
            })->orderBy('created_at', 'DESC')
                ->get();
            $repoFolio = new FolioNotaRepository();

            foreach ($actas_volantes as $av) {
                /** @var ActaVolante $av */
                $folio = $repoFolio->getFolioByActaVolante($av->id);

                $fecha = $av->mesa->fecha ?? $av->mesaAlumno->mesa->fecha;


                if (!$folio) {
                    $data['actas_incompletas'][] = [
                        'id' => $av->id,
                        'fecha' => $fecha,
                        'materia' => $av->materia()->first()->nombre
                    ];
                }

            }
            $materia = Materia::find($correlativa->id);

            $folios = $repoFolio->getFoliosNotaForAlumnoByMateria(
                $mesa_alumno->alumno_id, $materia, $mesa_fecha);

            if (count($folios) > 0) {
                foreach ($folios as $folio) {
                    if ($acta_volante->inscripcion && $acta_volante->inscripcion->mesa && $acta_volante->inscripcion->mesa->instancia) {
                        $nota_aprobado = $notas_aprobado->where('year', $acta_volante->inscripcion->mesa->instancia->year_nota)->first();

                        if ($acta_volante->promedio >= $nota_aprobado->valor) {
                            if (in_array($correlativa, $data['correlativas_incompletas'])) {
                                $data['correlativas_incompletas'] = array_diff($data['correlativas_incompletas'], [$correlativa]);
                            }
                            break;
                        }

                        if ($acta_volante->promedio < $nota_aprobado->valor) {
                            if (!in_array($correlativa, $data['correlativas_incompletas'])) {
                                array_push($data['correlativas_incompletas'], $correlativa);
                            }
                        }

                    }
                }
            } else {
                if (!in_array($correlativa, $data['correlativas_incompletas'])) {
                    array_push($data['correlativas_incompletas'], $correlativa);
                }
            }
        }
        return $data;
    }
}
