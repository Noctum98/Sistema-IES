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
    private $request;
    private $preinscripcion;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request,$preinscripcion = null)
    {
        $this->disk = Storage::disk('google');
        $this->request = $request;
        $this->preinscripcion = $preinscripcion;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dni_archivo = $this->request->file('dni_archivo_file');
        $dni_archivo2 = $this->request->file('dni_archivo_2_file');
        $comprobante = $this->request->file('comprobante_file');
        $certificado_archivo = $this->request->file('certificado_archivo_file');
        $certificado_archivo2 = $this->request->file('certificado_archivo_2_file');
        $primario = $this->request->file('primario_file');
        $curriculum = $this->request->file('curriculum_file');
        $ctrabajo = $this->request->file('ctrabajo_file');
        $nota = $this->request->file('nota_file');

        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect($this->disk->listContents($dir, $recursive));
        $dir = $contents->where('type', '=', 'dir')
            ->where('filename', '=', $this->request['dni'])
            ->first();

        if (!$dir) {
            $path_folder = $this->disk->makeDirectory($this->request['dni']);
            $contents = collect($this->disk->listContents($dir, $recursive));
            $dir = $contents->where('type', '=', 'dir')
                ->where('filename', '=', $this->request['dni'])
                ->first();
        }

        if ($dni_archivo) {
            $dni_nombre = time() . $dni_archivo->getClientOriginalName();


            $this->disk->put($dir['path'] . '/' . $dni_nombre, File::get($dni_archivo));
            $this->request['dni_archivo'] = $dni_nombre;
        }
        if ($dni_archivo2) {
            $dni_nombre2 = time() . $dni_archivo2->getClientOriginalName();

            $this->disk->put($dir['path'] . '/' . $dni_nombre2, File::get($dni_archivo2));
            $this->request['dni_archivo_2'] = $dni_nombre2;
        }
        if ($comprobante) {
            $comprobante_nombre = time() . $comprobante->getClientOriginalName();

            $this->disk->put($dir['path'] . '/' . $comprobante_nombre, File::get($comprobante));
            $this->request['comprobante'] = $comprobante_nombre;
        }
        if ($certificado_archivo) {
            $certificado_nombre = time() . $certificado_archivo->getClientOriginalName();

            $this->disk->put($dir['path'] . '/' . $certificado_nombre, File::get($certificado_archivo));
            $this->request['certificado_archivo'] = $certificado_nombre;
        }
        if ($certificado_archivo2) {
            $certificado_nombre2 = time() . $certificado_archivo2->getClientOriginalName();

            $this->disk->put($dir['path'] . '/' . $certificado_nombre2, File::get($certificado_archivo2));
            $this->request['certificado_archivo_2'] = $certificado_nombre2;
        }
        if ($primario) {
            $primario_nombre = time() . $primario->getClientOriginalName();

            $this->disk->put($dir['path'] . '/' . $primario_nombre, File::get($primario));
            $this->request['primario'] = $primario_nombre;
        }
        if ($curriculum) {
            $curriculum_nombre = time() . $curriculum->getClientOriginalName();

            $this->disk->put($dir['path'] . '/' . $curriculum_nombre, File::get($curriculum));
            $this->request['curriculum'] = $curriculum_nombre;
        }
        if ($ctrabajo) {
            $ctrabajo_nombre = time() . $ctrabajo->getClientOriginalName();

            $this->disk->put($dir['path'] . '/' . $ctrabajo_nombre, File::get($ctrabajo));
            $this->request['ctrabajo'] = $ctrabajo_nombre;
        }
        if ($nota) {
            $nota_nombre = time() . $nota->getClientOriginalName();

            $this->disk->put($dir['path'] . '/' . $nota_nombre, File::get($nota));
            $this->request['nota'] = $nota_nombre;
        }

        $this->request['estado'] = 'sin verificar';

        if($this->preinscripcion)
        {
            $this->preinscripcion->update($this->request->all());
        }else{
            $this->request['timecheck'] = time();
            $preinscripcion = Preinscripcion::create($this->request->all());
            Mail::to($preinscripcion->email)->send(new PreEnrolledFormReceived($preinscripcion));
        }
    }
}
