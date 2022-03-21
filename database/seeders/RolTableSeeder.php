<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol = new Rol();
        $rol->name = 'admin';
        $rol->description = 'Administrator';
        $rol->save();

        $rol = new Rol();
        $rol->name = 'coordinador';
        $rol->description = 'User';
        $rol->save();
    }
}
