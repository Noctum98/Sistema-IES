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
        $this->preinscripcion = $data;
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
            ->where('filename', '=', $this->preinscripcion['dni'])
            ->first();

        if (!$dir) {
            $path_folder = $this->disk->makeDirectory($this->preinscripcion['dni']);
            $contents = collect($this->disk->listContents($dir, $recursive));
            $dir = $contents->where('type', '=', 'dir')
                ->where('filename', '=', $this->preinscripcion['dni'])
                ->first();
        }

        if (isset($this->preinscripcion['dni_archivo'])) {
            $dni_archivo = Storage::disk('temp')->get($this->preinscripcion['dni_archivo']);
            $dni_nombre = $this->preinscripcion['dni_archivo'];

            $this->disk->put($dir['path'] . '/' . $dni_nombre, $dni_archivo);
            Storage::disk('temp')->delete($dni_nombre);
        }

        if (isset($this->preinscripcion['dni_archivo_2'])) {
            $dni_archivo2 = Storage::disk('temp')->get($this->preinscripcion['dni_archivo_2']);
            $dni_nombre2 = $this->preinscripcion['dni_archivo_2'];

            $this->disk->put($dir['path'] . '/' . $dni_nombre2, $dni_archivo2);
            Storage::disk('temp')->delete($dni_nombre2);
        }

        if (isset($this->preinscripcion['comprobante'])) {
            $comprobante = Storage::disk('temp')->get($this->preinscripcion['comprobante']);
            $comprobante_nombre = $this->preinscripcion['comprobante'];

            $this->disk->put($dir['path'] . '/' . $comprobante_nombre, $comprobante);
            Storage::disk('temp')->delete($comprobante_nombre);
        }


        if (isset($this->preinscripcion['certificado_archivo'])) {
            $certificado_archivo = Storage::disk('temp')->get($this->preinscripcion['certificado_archivo']);
            $certificado_nombre = $this->preinscripcion['certificado_archivo'];

            $this->disk->put($dir['path'] . '/' . $certificado_nombre, $certificado_archivo);
            Storage::disk('temp')->delete($certificado_nombre);
        }
        if (isset($this->preinscripcion['certificado_archivo_2'])) {
            $certificado_archivo2 = Storage::disk('temp')->get($this->preinscripcion['certificado_archivo_2']);
            $certificado_nombre2 = $this->preinscripcion['certificado_archivo_2'];

            $this->disk->put($dir['path'] . '/' . $certificado_nombre2, $certificado_archivo2);
            Storage::disk('temp')->delete($certificado_nombre2);
        }
        if (isset($this->preinscripcion['primario'])) {
            $primario = Storage::disk('temp')->get($this->preinscripcion['primario']);
            $primario_nombre = $this->preinscripcion['primario'];

            $this->disk->put($dir['path'] . '/' . $primario_nombre, $primario);
            Storage::disk('temp')->delete($primario_nombre);
        }
        if (isset($this->preinscripcion['curriculum'])) {
            $curriculum = Storage::disk('temp')->get($this->preinscripcion['curriculum']);
            $curriculum_nombre = $this->preinscripcion['curriculum'];

            $this->disk->put($dir['path'] . '/' . $curriculum_nombre, $curriculum);
            Storage::disk('temp')->delete($curriculum_nombre);
        }
        if (isset($this->preinscripcion['ctrabajo'])) {
            $ctrabajo = Storage::disk('temp')->get($this->preinscripcion['ctrabajo']);
            $ctrabajo_nombre = $this->preinscripcion['ctrabajo'];

            $this->disk->put($dir['path'] . '/' . $ctrabajo_nombre, $ctrabajo);
            Storage::disk('temp')->delete($ctrabajo_nombre);
        }
        if (isset($this->preinscripcion['nota'])) {
            $nota = Storage::disk('temp')->get($this->preinscripcion['nota']);
            $nota_nombre = $this->preinscripcion['nota'];

            $this->disk->put($dir['path'] . '/' . $nota_nombre, $nota);
            Storage::disk('temp')->delete($nota_nombre);
        }
    }
}
