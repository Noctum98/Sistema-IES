<?php

namespace App\Services;

use App\Models\Config\Mail;
use App\Models\MailCheck;

class MailService
{
    public function checkEmail($timecheck)
    {
        $mailCheck = MailCheck::where('timecheck',$timecheck)->first();

        $mailCheck->checked = true;

        $mailCheck->update();

        return $mailCheck;
    }

    public function store($datos)
    {
        if($datos['tipo'] == 'Baja Mesas')
        {
            $datos['contenido'] = $datos['instancia']['nombre'];

            foreach($datos['motivos'] as $motivo)
            {
                $datos['contenido'] = $datos[' - Motivos: '].$motivo.'|';
            }
        }

        if($datos['tipo'] == 'Check Email')
        {
            $datos['contenido'] = 'Checkeo de email';
        }

        if($datos['tipo'] == 'Error Preinscripción')
        {
            $datos['contenido'] = 'Error Archivos: ';

            foreach($datos['archivos'] as $archivo)
            {
                $datos['contenido'] = $datos['contenido'].$archivo.'|';
            }
        }

        if($datos['tipo'] == 'Matriculación Eliminada')
        {
            $datos['contenido'] = 'Errores: ';

            foreach($datos['errores'] as $error)
            {
                $datos['contenido'] = $datos['contenido'].$error.'|';
            }

            $datos['contenido'] = $datos['contenido'].$datos['motivo'];
        }

        if($datos['tipo'] == 'Matriculación Enviada')
        {
            $datos['contenido'] = 'Matriculación creada y enviada.';
        }

        if($datos['tipo'] == 'Matriculación Verificada')
        {
            $datos['contenido'] = 'Matriculación verificada y usuario creado: '.$datos['alumno']['dni'];
        }

        if($datos['tipo'] == 'Mesa Inscripción')
        {
            $datos['contenido'] = $datos['instancia']['nombre'].': ';

            foreach($datos['materias'] as $materia)
            {
                $datos['contenido'] = $datos['contenido'].$materia.'|';
            }
        }

        if($datos['tipo'] == 'Baja Mesas Alumno')
        {
            $datos['contenido'] = $datos['instancia']['nombre'].': '.$datos['materia']['nombre'];
        }

        if($datos['tipo'] == 'Preinscripción')
        {
            $datos['contenido'] = 'Preinscripción Enviada';
        }

        if($datos['tipo'] == 'Preinscripción Verificada')
        {
            $datos['contenido'] = 'Preinscripción Verificada';
        }

        Mail::create($datos);
    }
}