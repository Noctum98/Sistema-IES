<?php

namespace App\Console\Commands;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Console\Command;

class insertRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertRoles {rolBuscar} {rolInsertar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserta roles masivamente a definidos usuarios';

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
        $rolBuscar = $this->argument('rolBuscar');
        $rolInsertar = $this->argument('rolInsertar');

        $rol = Rol::where('nombre',$rolBuscar)->first();
        $rol_nuevo = Rol::where('nombre',$rolInsertar)->first();

        if($rol && $rol_nuevo)
        {   
            $users = User::whereHas('roles',function($query) use ($rol){
                return $query->where('roles.id',$rol->id);
            })->get();

            foreach($users as $user)
            {
                if(!$user->hasRole($rol_nuevo->nombre)){
                    $user->roles()->attach($rol_nuevo);
                }
            }
            $this->info('Roles insertados correctamente!');
        }else{
            $this->info('Los roles que indica no son correctos!');
        }
        return 0;
    }
}
