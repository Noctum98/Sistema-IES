<?php

namespace App\Services;

use App\Models\Parameters\Calendario;
use Carbon\Carbon;

class MesaService
{
    protected $feriados;
    const T_M = '14:00';
    const T_T = '23:59';
    const T_V = '23:59';

    public function verificarInscripcionesEspeciales($inscripciones, $materia, $instancia)
    {
        $comisiones = false;
        $mesa_selected = null;
        if (count($materia->mesas_instancias($instancia->id)) >= 1) {

            foreach ($materia->mesas_instancias($instancia->id) as $mesa) {
                foreach ($inscripciones as $inscripcion) {

                    if ($mesa->comision_id) {
                        $comisiones = true;

                        if ($mesa->instancia->estado == 'activa') {
                            $comisionAlumno = $inscripcion->alumno->comisiones->where('id', $mesa->comision_id)->first();
                            if ($comisionAlumno) {
                                $inscripcion->update(['mesa_id' => $mesa->id, 'segundo_llamado' => 0]);
                            }
                        }
                    } else {
                        if ($mesa->instancia->estado == 'activa') {
                            $inscripcion->update(['mesa_id' => $mesa->id, 'segundo_llamado' => 0]);
                        }
                    }
                }

                $mesa_selected = $mesa;
            }
        }


        return [
            'mesa' => $mesa_selected,
            'comisiones' => $comisiones
        ];
    }

    public function setCierreMesa($fecha, $materia, $feriados)
    {
        $inicio_fecha = date("d-n-Y", strtotime($fecha . '-1 day'));

        $contador = 0;
        while ($contador < 2) {

            if ($this->isHabil($inicio_fecha, $feriados)) {
                $contador++;
            }

            if ($contador != 2) {
                $inicio_fecha = date("d-n-Y", strtotime($inicio_fecha . '-1 day'));
            }
        }

        $cierre = strtotime($this->setFechaTurno($materia, $inicio_fecha));

        return $cierre;
    }

    public function isHabil($fecha, $feriados)
    {
        if (in_array($fecha, $feriados) || date('D', strtotime($fecha))  == 'Sat' || date('D', strtotime($fecha)) == 'Sun') {

            return false;
        } else {

            return true;
        }
    }

    private function setFechaTurno($materia, $fecha)
    {

        $turno = $materia->carrera->turno;
        $hora = '00:00';
        switch ($turno) {
            case 'mañana':
                $hora = $this::T_M;
                break;
            case 'tarde':
                $hora = $this::T_T;
                break;
            case 'vespertino':
                $hora = $this::T_V;
        }

        return $fecha . 'T' . $hora;
    }

    public function limpiarFeriados($feriados, $instancia)
    {
        $feriadosLimpios = [];
        foreach ($feriados as $feriado) {
            $feriadoLimpio = $feriado->dia . '-' . $feriado->mes . '-' . $instancia->año;
            array_push($feriadosLimpios, $feriadoLimpio);
        }

        return $feriadosLimpios;
    }

    public function fechaBloqueo($mesa,$hours)
    {
        $primer_llamado = $mesa->fecha;
        $segundo_llamado = $mesa->fecha_segundo;
        $fechaPrimerLlamado = Carbon::parse($primer_llamado);
        $fechaSegundoLlamado = $segundo_llamado ? Carbon::parse($segundo_llamado) : null;

        $primer_llamado_cierre = false;
        $segundo_llamado_cierre = false;

        // Verificar si la fecha recibida más 48 horas es mayor que la fecha actual
        if ($fechaPrimerLlamado->addHours($hours)->isPast()) {
            
            $primer_llamado_cierre = true;
            $mesa->cierre_profesor = true;
         }
        
        // Verificar si la fecha recibida más 48 horas es mayor que la fecha actual
        if ($fechaSegundoLlamado && $fechaSegundoLlamado->addHours($hours)->isPast()) {
            
            $segundo_llamado_cierre = true;
            $mesa->cierre_profesor_segundo = true;

        }
        
        $mesa->update();
        return [
            'cierre_primer_llamado' => $primer_llamado_cierre,
            'cierre_segundo_llamado' => $segundo_llamado_cierre
        ];
    }
}
