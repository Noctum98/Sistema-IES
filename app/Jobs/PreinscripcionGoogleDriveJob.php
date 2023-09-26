<?php

namespace App\Jobs;

use App\Mail\PreEnrolledFormReceived;
use App\Models\Preinscripcion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class PreinscripcionGoogleDriveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $disk;
    private $data;
    private $preinscripcion;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$preinscripcion = null)
    {
        $this->data = $data;
        $this->preinscripcion = $preinscripcion;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->disk = Storage::disk('google');

        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect($this->disk->listContents($dir, $recursive));
        $dir = $contents->where('type', '=', 'dir')
            ->where('filename', '=', $this->data['dni'])
            ->first();

        if (!$dir) {
            $path_folder = $this->disk->makeDirectory($this->data['dni']);
            $contents = collect($this->disk->listContents($dir, $recursive));
            $dir = $contents->where('type', '=', 'dir')
                ->where('filename', '=', $this->data['dni'])
                ->first();
        }

        if (isset($this->data['dni_path'])) {
            $dni_archivo = Storage::disk('temp')->get($this->data['dni_archivo']);
            $dni_nombre = $this->data['dni_archivo'];

            $this->disk->put($dir['path'] . '/' . $dni_nombre, $dni_archivo);
            Storage::disk('temp')->delete($dni_nombre);
        }

        if (isset($this->data['dni2_path'])) {
            $dni_archivo2 = Storage::disk('temp')->get($this->data['dni_archivo_2']);
            $dni_nombre2 = $this->data['dni_archivo_2'];

            $this->disk->put($dir['path'] . '/' . $dni_nombre2, $dni_archivo2);
            Storage::disk('temp')->delete($dni_nombre2);
        }

        if (isset($this->data['comprobante_path'])) {
            $comprobante = Storage::disk('temp')->get($this->data['comprobante']);
            $comprobante_nombre = $this->data['comprobante'];

            $this->disk->put($dir['path'] . '/' . $comprobante_nombre, $comprobante);
            Storage::disk('temp')->delete($comprobante_nombre);
        }


        if (isset($this->data['certificado_path'])) {
            $certificado_archivo = Storage::disk('temp')->get($this->data['certificado_archivo']);
            $certificado_nombre = $this->data['certificado_archivo'];

            $this->disk->put($dir['path'] . '/' . $certificado_nombre, $certificado_archivo);
            Storage::disk('temp')->delete($certificado_nombre);
        }
        if (isset($this->data['certificado2_path'])) {
            $certificado_archivo2 = Storage::disk('temp')->get($this->data['certificado_archivo_2']);
            $certificado_nombre2 = $this->data['certificado_archivo_2'];

            $this->disk->put($dir['path'] . '/' . $certificado_nombre2, $certificado_archivo2);
            Storage::disk('temp')->delete($certificado_nombre2);
        }
        if (isset($this->data['primario_path'])) {
            $primario = Storage::disk('temp')->get($this->data['primario']);
            $primario_nombre = $this->data['primario'];

            $this->disk->put($dir['path'] . '/' . $primario_nombre, $primario);
            Storage::disk('temp')->delete($primario_nombre);
        }
        if (isset($this->data['curriculum_path'])) {
            $curriculum = Storage::disk('temp')->get($this->data['curriculum']);
            $curriculum_nombre = $this->data['curriculum'];

            $this->disk->put($dir['path'] . '/' . $curriculum_nombre, $curriculum);
            Storage::disk('temp')->delete($curriculum_nombre);
        }
        if (isset($this->data['ctrabajo_path'])) {
            $ctrabajo = Storage::disk('temp')->get($this->data['ctrabajo']);
            $ctrabajo_nombre = $this->data['ctrabajo'];

            $this->disk->put($dir['path'] . '/' . $ctrabajo_nombre, $ctrabajo);
            Storage::disk('temp')->delete($ctrabajo_nombre);
        }
        if (isset($this->data['nota_path'])) {
            $nota = Storage::disk('temp')->get($this->data['nota']);
            $nota_nombre = $this->data['nota'];

            $this->disk->put($dir['path'] . '/' . $nota_nombre, $nota);
            Storage::disk('temp')->delete($nota_nombre);
        }

        $this->data['estado'] = 'sin verificar';

        if($this->preinscripcion)
        {
            $this->preinscripcion->update($this->data);
        }else{
            $this->data['timecheck'] = time();
            $preinscripcion = Preinscripcion::create($this->data);
            Mail::to($preinscripcion->email)->send(new PreEnrolledFormReceived($preinscripcion));
        }
    }
}
