<?php

namespace Database\Factories;

use App\Models\ActaVolante;
use App\Models\Materia;
use App\Models\Mesa;
use App\Models\MesaAlumno;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ActaVolanteFactory extends Factory
{
    protected $model = ActaVolante::class;

    public function definition(): array
    {
        return [
            'alumno_id' => $this->faker->randomNumber(),
            'instancia_id' => $this->faker->randomNumber(),
            'nota_escrito' => $this->faker->word(),
            'nota_oral' => $this->faker->word(),
            'promedio' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'libro_id' => $this->faker->randomNumber(),

            'materia_id' => Materia::factory(),
            'mesa_id' => Mesa::factory(),
            'mesa_alumno_id' => MesaAlumno::factory(),
        ];
    }
}
