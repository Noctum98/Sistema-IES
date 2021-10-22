<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'alumno_dni' => [
            'driver' => 'local',
            'root' => storage_path('app/alumno_dni'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'comprobante' => [
            'driver' => 'local',
            'root' => storage_path('app/comprobante'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'alumno_vacunacion' => [
            'driver' => 'local',
            'root' => storage_path('app/alumno_vacunacion'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'alumno_partida' => [
            'driver' => 'local',
            'root' => storage_path('app/alumno_partida'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'alumno_foto' => [
            'driver' => 'local',
            'root' => storage_path('app/alumno_foto'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'alumno_titulo' => [
            'driver' => 'local',
            'root' => storage_path('app/alumno_titulo'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
          'alumno_certificado' => [
            'driver' => 'local',
            'root' => storage_path('app/alumno_certificado'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'alumno_psicofisico' => [
            'driver' => 'local',
            'root' => storage_path('app/alumno_psicofisico'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'alumno_primario' => [
            'driver' => 'local',
            'root' => storage_path('app/alumno_primario'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'alumno_curriculum' => [
            'driver' => 'local',
            'root' => storage_path('app/alumno_curriculum'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'alumno_ctrabajo' => [
            'driver' => 'local',
            'root' => storage_path('app/alumno_ctrabajo'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'alumno_nota' => [
            'driver' => 'local',
            'root' => storage_path('app/alumno_nota'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'backups' => [
            'driver' => 'local',
            'root' => storage_path('app/backups'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
