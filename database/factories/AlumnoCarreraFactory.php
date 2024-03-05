<?php

namespace Database\Factories;

use App\Models\AlumnoCarrera;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AlumnoCarreraFactory extends Factory
{
    protected $model = AlumnoCarrera::class;

    public function definition(): array
    {
        return [
            'alumno_id' => $this->faker->randomNumber(),
            'carrera_id' => $this->faker->randomNumber(),
            'año' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'ciclo_lectivo' => $this->faker->randomNumber(),
        ];
    }
}
