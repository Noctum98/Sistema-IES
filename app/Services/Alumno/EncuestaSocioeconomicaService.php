<?php

namespace App\Services\Alumno;

use App\Models\Alumno;
use App\Models\Materia;
use App\Models\Proceso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EncuestaSocioeconomicaService
{
    public function procesarDatos($request)
    {
        $acceso_internet = '';
        foreach($request['acceso_internet'] as $acceso)
        {
            $acceso_internet = $acceso_internet.'|'.$acceso;
        }

        $request['acceso_internet'] = $acceso_internet;


        $herramientas_tecnologicas = '';
        foreach($request['herramientas_tecnologicas'] as $herramientas)
        {
            $herramientas_tecnologicas = $herramientas_tecnologicas.'|'.$herramientas;
        }

        $request['herramientas_tecnologicas'] = $herramientas_tecnologicas;

        $edad_hijos = '';
        foreach($request['edad_hijos'] as $edad)
        {
            $edad_hijos = $edad_hijos.'|'.$edad;
        }
        $request['edad_hijos'] = $edad_hijos;

        $subsidios = '';
        foreach($request['subsidios'] as $subsidio)
        {
            $subsidios = $subsidios.'|'.$subsidio;
        }
        $request['subsidios'] = $subsidios;

        $transporte_utilizado = '';
        foreach($request['transporte_utilizado'] as $transporte)
        {
            $transporte_utilizado = $transporte_utilizado.'|'.$transporte;
        }
        $request['transporte_utilizado'] = $transporte_utilizado;

        $familia_enfermedad = '';
        foreach($request['familia_enfermedad'] as $fenfermedad)
        {
            $familia_enfermedad = $familia_enfermedad.'|'.$fenfermedad;
        }
        $request['familia_enfermedad'] = $familia_enfermedad;

        $familia_discapacidad = '';
        foreach($request['familia_discapacidad'] as $fdiscapacidad)
        {
            $familia_discapacidad = $familia_discapacidad.'|'.$fdiscapacidad;
        }
        $request['familia_discapacidad'] = $familia_discapacidad;

        $familia_obra_social = '';
        foreach($request['familia_obra_social'] as $fobrasocial)
        {
            $familia_obra_social = $familia_obra_social.'|'.$fobrasocial;
        }
        $request['familia_obra_social'] = $familia_obra_social;

        $desalojo_vivienda = '';
        foreach($request['desalojo_vivienda'] as $desalojo)
        {
            $desalojo_vivienda = $desalojo_vivienda.'|'.$desalojo;
        }
        $request['desalojo_vivienda'] = $desalojo_vivienda;

        $violencia_intrafamiliar = '';
        foreach($request['violencia_intrafamiliar'] as $violencia)
        {
            $violencia_intrafamiliar = $violencia_intrafamiliar.'|'.$violencia;
        }
        $request['violencia_intrafamiliar'] = $violencia_intrafamiliar;


        $violencia_genero = '';
        foreach($request['violencia_genero'] as $vgenero)
        {
            $violencia_genero = $violencia_genero.'|'.$vgenero;
        }
        $request['violencia_genero'] = $violencia_genero;

        $fallecimiento_conviviente = '';
        foreach($request['fallecimiento_conviviente'] as $fconviviente)
        {
            $fallecimiento_conviviente = $fallecimiento_conviviente.'|'.$fconviviente;
        }
        $request['fallecimiento_conviviente'] = $fallecimiento_conviviente;

        $situaciones_consumo = '';
        foreach($request['situaciones_consumo'] as $situaciones)
        {
            $situaciones_consumo = $situaciones_consumo.'|'.$situaciones;
        }
        $request['situaciones_consumo'] = $situaciones_consumo;

        $accidentes_graves = '';
        foreach($request['accidentes_graves'] as $accidentes)
        {
            $accidentes_graves = $accidentes_graves.'|'.$accidentes;
        }
        $request['accidentes_graves'] = $accidentes_graves;

        $condenas_extramuros = '';
        foreach($request['condenas_extramuros'] as $cextramuros)
        {
            $condenas_extramuros = $condenas_extramuros.'|'.$cextramuros;
        }
        $request['condenas_extramuros'] = $condenas_extramuros;

        $embargo_judicial = '';
        foreach($request['embargo_judicial'] as $ejudicial)
        {
            $embargo_judicial = $embargo_judicial.'|'.$ejudicial;
        }
        $request['embargo_judicial'] = $embargo_judicial;

        $problemas_judiciales = '';
        foreach($request['problemas_judiciales'] as $pjudicial)
        {
            $problemas_judiciales = $problemas_judiciales.'|'.$pjudicial;
        }
        $request['problemas_judiciales'] = $problemas_judiciales;


        if($request['comprobanete_progresar'])
        {
            $comprobante = $request->file('comprobanete_progresar');
            $archivo_nombre = uniqid() . $comprobante->getClientOriginalName();

            Storage::disk('temp')->put($archivo_nombre, file_get_contents($comprobante));

            $request['comprobanete_progresar'] = $archivo_nombre;
        }

        return $request;
    }
}