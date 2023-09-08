<?php

namespace App\Services;

class MesaService
{
    protected $feriados;
    const T_M = '14:00';
    const T_T = '23:59';
    const T_V = '23:59';
    public function __construct()
    {
        $this->feriados = [
            '19-02-2023',
            '20-02-2023',
            '21-02-2023',
            '26-02-2023',
            '27-02-2023',
            '28-02-2023',
            '09-07-2023',
            '15-08-2023',
            '25-08-2023',
            '02-09-2023',
            '07-10-2023',
            '10-10-2023',
            '20-11-2023',
            '21-11-2023',
            '08-12-2023',
            '09-12-2023',
        ];
    }

    public function verificarInscripcionesEspeciales($inscripciones, $materia, $instancia)
    {
        $comisiones = false;
        if (count($materia->mesas_instancias($instancia->id)) >= 1 ) {

            foreach($materia->mesas_instancias($instancia->id) as $mesa)
            {
                foreach ($inscripciones as $inscripcion) {

                    if($mesa->comision_id)
                    {
                        $comisiones = true;
                        $comisionAlumno = $inscripcion->alumno->comisiones->where('id',$mesa->comision_id)->first();
                        if($comisionAlumno){
                            $inscripcion->update(['mesa_id'=>$mesa->id,'segundo_llamado' => 0]);
                        }
                    }else{
                        $inscripcion->update(['mesa_id' => $mesa->id, 'segundo_llamado' => 0]);
                    }
                }
            }

            return [
                'mesa' => $mesa,
                'comisiones' => $comisiones
            ];
        }
    }

    public function setCierreMesa($fecha, $materia)
    {
        $inicio_fecha = date("d-m-Y", strtotime($fecha . '-1 day'));

        $contador = 0;
        while ($contador < 2) {

            if ($this->isHabil($inicio_fecha)) {
                $contador++;
            }

            if ($contador != 2) {
                $inicio_fecha = date("d-m-Y", strtotime($inicio_fecha . '-1 day'));
            }
        }

        $cierre = strtotime($this->setFechaTurno($materia, $inicio_fecha));

        return $cierre;
    }

    private function isHabil($fecha)
    {
        if (in_array($fecha, $this->feriados) || date('D', strtotime($fecha))  == 'Sat' || date('D', strtotime($fecha)) == 'Sun') {
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
}
