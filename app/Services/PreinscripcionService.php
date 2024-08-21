<?php

namespace App\Services;

use App\Mail\PreEnrolledFormReceived;
use App\Models\Alumno;
use App\Models\Materia;
use App\Models\Preinscripcion;
use App\Models\Proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PreinscripcionService
{
    public function guardarArchivosTemporales(Request $request, $preinscripcion = null)
    {
        $dni_archivo = $request->file('dni_archivo_file');
        $dni_archivo2 = $request->file('dni_archivo_2_file');
        $comprobante = $request->file('comprobante_file');
        $certificado_archivo = $request->file('certificado_archivo_file');
        $certificado_archivo2 = $request->file('certificado_archivo_2_file');


        $data = [
            'nombres'       =>  $request['nombres'],
            'apellidos'     =>  $request['apellidos'],
            'dni'           =>  $request['dni'],
            'cuil'          =>  $request['cuil'],
            'fecha'         =>  $request['fecha'],
            'email'         =>  $request['email'],
            'edad'          =>  $request['edad'],
            'nacionalidad'  =>  $request['nacionalidad'],
            'domicilio'     =>  $request['domicilio'],
            'residencia'    =>  $request['residencia'],
            'telefono'      =>  $request['telefono'],
            'trabajo'       =>  $request['trabajo'],
            'condicion_s'   =>  $request['condicion_s'],
            'escolaridad'   =>  $request['escolaridad'],
            'escuela_s'     =>  $request['escuela_s'],
            'materias_s'     => $request['materias_s'],
            'conexion'      =>  $request['conexion'],
            'articulo_septimo' => $request['articulo_septimo'] ?? 0,
            'carrera_id' => $request['carrera_id'],
        ];

        if ($preinscripcion) {
            $request['gdrive_storage'] = $preinscripcion->gdrive_storage;
        } else {
            $request['gdrive_storage'] = false;
        }

        if ($dni_archivo) {
            $dni_nombre = uniqid() . $dni_archivo->getClientOriginalName();

            Storage::disk('temp')->put($dni_nombre, file_get_contents($dni_archivo));

            // Obtén la ruta completa del archivo almacenado temporalmente
            $data['dni_path'] = storage_path('app/temp/' . $dni_nombre);
            $data['dni_archivo'] = $dni_nombre;
        }
        if ($dni_archivo2) {
            $dni_nombre2 = uniqid() . $dni_archivo2->getClientOriginalName();

            Storage::disk('temp')->put($dni_nombre2, file_get_contents($dni_archivo2));
            $data['dni2_path'] = storage_path('app/temp/' . $dni_nombre2);
            $data['dni_archivo_2'] = $dni_nombre2;
        }
        if ($comprobante) {
            $comprobante_nombre = uniqid() . $comprobante->getClientOriginalName();

            Storage::disk('temp')->put($comprobante_nombre, file_get_contents($comprobante));
            $data['comprobante_path'] = storage_path('app/temp/' . $comprobante_nombre);
            $data['comprobante'] = $comprobante_nombre;
        }
        if ($certificado_archivo) {
            $certificado_nombre = uniqid() . $certificado_archivo->getClientOriginalName();

            Storage::disk('temp')->put($certificado_nombre, file_get_contents($certificado_archivo));
            $data['certificado_path'] = storage_path('app/temp/' . $certificado_nombre);
            $data['certificado_archivo'] = $certificado_nombre;
        }
        if ($certificado_archivo2) {
            $certificado_nombre2 = uniqid() . $certificado_archivo2->getClientOriginalName();

            Storage::disk('temp')->put($certificado_nombre2, file_get_contents($certificado_archivo2));
            $data['certificado2_path'] = storage_path('app/temp/' . $certificado_nombre2);
            $data['certificado_archivo_2'] = $certificado_nombre2;
        }


        $data['estado'] = 'sin verificar';

        if ($preinscripcion) {
            $preinscripcion->update($data);
        } else {
            $data['timecheck'] = time();
            $preinscripcion = Preinscripcion::create($data);
            Mail::to($preinscripcion->email)->send(new PreEnrolledFormReceived($preinscripcion));

            if($preinscripcion->articulo_septimo)
            {
                Mail::to('articulo7@iesvu.edu.ar')->send(new PreEnrolledFormReceived($preinscripcion));
            }
        }

        return $data;
    }


    public function guardarArchivos7mo(Request $request, $preinscripcion)
    {
        $primario = $request->file('primario_file');
        $curriculum = $request->file('curriculum_file');
        $ctrabajo = $request->file('ctrabajo_file');
        $nota = $request->file('nota_file');

        if ($primario) {
            $primario_nombre = uniqid() . $primario->getClientOriginalName();

            Storage::disk('temp')->put($primario_nombre, file_get_contents($primario));
            $data['primario_path'] = storage_path('app/temp/' . $primario_nombre);
            $data['primario'] = $primario_nombre;
        }
        if ($curriculum) {
            $curriculum_nombre = uniqid() . $curriculum->getClientOriginalName();

            Storage::disk('temp')->put($curriculum_nombre, file_get_contents($curriculum));
            $data['curriculum_path'] = storage_path('app/temp/' . $curriculum_nombre);
            $data['curriculum'] = $curriculum_nombre;
        }
        if ($ctrabajo) {
            $ctrabajo_nombre = uniqid() . $ctrabajo->getClientOriginalName();

            Storage::disk('temp')->put($ctrabajo_nombre, file_get_contents($ctrabajo));
            $data['ctrabajo_path'] = storage_path('app/temp/' . $ctrabajo_nombre);
            $data['ctrabajo'] = $ctrabajo_nombre;
        }
        if ($nota) {
            $nota_nombre = uniqid() . $nota->getClientOriginalName();

            Storage::disk('temp')->put($nota_nombre, file_get_contents($nota));
            $data['nota_path'] = storage_path('app/temp/' . $nota_nombre);
            $data['nota'] = $nota_nombre;
        }

        $preinscripcion->update($data);

        return $data;
    }

    public function eliminarPreinscripcion($preinscripcion)
    {

        $files = [
            $preinscripcion->dni_archivo,
            $preinscripcion->dni_archivo_2,
            $preinscripcion->comprobante,
            $preinscripcion->certificado_archivo,
            $preinscripcion->certificado_archivo_2,
            $preinscripcion->primario,
            $preinscripcion->curriculum,
            $preinscripcion->ctrabajo,
            $preinscripcion->nota,
        ];

        $disk = 'temp'; // Asegúrate de que este es el nombre del disco configurado en config/filesystems.php

        foreach ($files as $file) {
            if ($file && Storage::disk($disk)->exists($file)) {
                Storage::disk($disk)->delete($file);
            } elseif ($file) {
                echo "El archivo $file no existe.<br>";
            }
        }
    }
}
