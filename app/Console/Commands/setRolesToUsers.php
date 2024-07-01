<?php

namespace App\Console\Commands;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Console\Command;

class setRolesToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:setRolesToUsers {rol} {rol_group}';

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
        $rol_argument = $this->argument('rol');
        $rol_group_argument = $this->argument('rol_group');

        $rol = Rol::where('nombre',$rol_argument)->first();

        $rol_group = Rol::where('nombre',$rol_group_argument)->first();

        if($rol && $rol_group)
        {
            $users = User::whereHas('roles',function($query) use ($rol_group){
                $query->where('roles.id',$rol_group->id);
            })->get();

            foreach($users as $user)
            {
                $user->roles()->attach($rol);
            }
        }

        return Command::SUCCESS;
    }
}
