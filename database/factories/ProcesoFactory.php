<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Cargo;
use App\Models\CondicionMateria;
use App\Models\Estados;
use App\Models\Materia;
use App\Models\Proceso;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProcesoFactory extends Factory
{
    protected $model = Proceso::class;

    public function definition(): array
    {
        return [
            'habilitado_campo' => $this->faker->boolean(),
            'ciclo_lectivo' => $this->faker->randomNumber(),
            'operador_id' => $this->faker->randomNumber(),
            'nota_recuperatorio' => $this->faker->randomNumber(),
            'nota_global' => $this->faker->randomNumber(),
            'porcentaje_final_calificaciones' => $this->faker->randomNumber(),
            'final_calificaciones' => $this->faker->randomNumber(),
            'cierre' => $this->faker->boolean(),
            'final_asistencia' => $this->faker->randomFloat(),
            'final_trabajos' => $this->faker->randomFloat(),
            'final_parciales' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'porcentaje_final_trabajos' => $this->faker->randomFloat(),
            'observacion_global' => $this->faker->word(),

            'alumno_id' => Alumno::factory(),
            'materia_id' => Materia::factory(),
            'cargo_id' => Cargo::factory(),
            'estado_id' => Estados::factory(),
            'condicion_materia_id' => CondicionMateria::factory(),
            'inscripcion_id' => AlumnoCarrera::factory(),
        ];
    }
}
