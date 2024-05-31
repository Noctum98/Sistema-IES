<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public function store($disk, $file)
    {
        $filename = uniqid() . $file->getClientOriginalName();

        Storage::disk($disk)->put($filename, file_get_contents($file));

        return $filename;
    }

    public function show($disk, $file)
    {
        $rutaArchivo = $disk. '/' . $file;

        $rutaCompleta = storage_path("app/{$rutaArchivo}");

        $mimeType = mime_content_type($rutaCompleta);

        if (Storage::disk('local')->exists($rutaArchivo)) {
            $headers = [
                'Content-Type' => $mimeType,
            ];

            return response()->file($rutaCompleta, $headers);
        } else {
            abort(404, 'Archivo no encontrado');
        }
    }
}
