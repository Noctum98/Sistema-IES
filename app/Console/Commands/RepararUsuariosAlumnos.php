<?php

namespace App\Console\Commands;

use App\Models\Alumno;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Console\Command;

class RepararUsuariosAlumnos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:repararUsuariosAlumnos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Alumno::whereNotNull('user_id')
            ->each(function ($alumno) {
                $user = User::withTrashed()->find($alumno->user_id);

                if ($user && $user->deleted_at != null) {
                    $user->restore();

                    if(!$user->hasRole('alumno'))
                    {
                        $user->roles()->attach(Rol::find(6));
                    }
                }
            });
    }
}
