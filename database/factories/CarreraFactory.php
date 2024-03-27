<?php

namespace Database\Factories;

use App\Models\Carrera;
use App\Models\Sede;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CarreraFactory extends Factory
{
    protected $model = Carrera::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'coordinador' => $this->faker->randomNumber(),
            'referente_p' => $this->faker->randomNumber(),
            'referente_s' => $this->faker->randomNumber(),
            'titulo' => $this->faker->word(),
            'años' => $this->faker->randomNumber(),
            'resolucion' => $this->faker->word(),
            'modalidad' => $this->faker->word(),
            'turno' => $this->faker->word(),
            'vacunas' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'link_inscripcion' => $this->faker->word(),
            'preinscripcion_habilitada' => $this->faker->boolean(),
            'matriculacion_habilitada' => $this->faker->boolean(),

            'sede_id' => Sede::factory(),
        ];
    }
}
