<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Instancia;
use App\Models\Materia;
use App\Models\Mesa;
use App\Models\MesaAlumno;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MesaAlumnoFactory extends Factory
{
    protected $model = MesaAlumno::class;

    public function definition(): array
    {
        return [
            'segundo_llamado' => $this->faker->randomNumber(),
            'nombres' => $this->faker->word(),
            'apellidos' => $this->faker->word(),
            'dni' => $this->faker->word(),
            'correo' => $this->faker->word(),
            'telefono' => $this->faker->word(),
            'estado_baja' => $this->faker->randomNumber(),
            'confirmado' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'motivo_baja' => $this->faker->word(),

            'mesa_id' => Mesa::factory(),
            'alumno_id' => Alumno::factory(),
            'materia_id' => Materia::factory(),
            'instancia_id' => Instancia::factory(),
            'user_id' => User::factory(),
        ];
    }
}
