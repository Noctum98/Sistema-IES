<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Carrera;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AlumnoCarreraFactory extends Factory
{
    protected $model = AlumnoCarrera::class;

    public function definition(): array
    {
        return [
            'año' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'ciclo_lectivo' => $this->faker->randomNumber(),
            'fecha_primera_acreditacion' => $this->faker->word(),
            'fecha_ultima_acreditacion' => $this->faker->word(),
            'cohorte' => $this->faker->word(),
            'legajo_completo' => $this->faker->boolean(),
            'aprobado' => $this->faker->boolean(),
            'regularidad' => $this->faker->word(),

            'alumno_id' => Alumno::factory(),
            'carrera_id' => Carrera::factory(),
        ];
    }
}
