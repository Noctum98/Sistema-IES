<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public function store($disk,$file)
    {
        $filename = uniqid().$file->getClientOriginalName();

        Storage::disk($disk)->put($filename,file_get_contents($file));

        return $filename;
    }

}