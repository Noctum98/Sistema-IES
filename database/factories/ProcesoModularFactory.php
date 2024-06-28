<?php

namespace Database\Factories;

use App\Models\Proceso;
use App\Models\ProcesoModular;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProcesoModularFactory extends Factory
{
    protected $model = ProcesoModular::class;

    public function definition(): array
    {
        return [
            'promedio_final_porcentaje' => $this->faker->randomFloat(),
            'promedio_final_nota' => $this->faker->randomFloat(),
            'ponderacion_promedio_final' => $this->faker->randomNumber(),
            'trabajo_final_porcentaje' => $this->faker->randomFloat(),
            'trabajo_final_nota' => $this->faker->randomFloat(),
            'ponderacion_trabajo_final' => $this->faker->randomNumber(),
            'nota_final_porcentaje' => $this->faker->randomFloat(),
            'nota_final_nota' => $this->faker->randomFloat(),
            'cierre' => $this->faker->boolean(),
            'operador_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'asistencia_final_porcentaje' => $this->faker->randomFloat(),
            'asistencia_practica_profesional' => $this->faker->randomFloat(),
            'porcentaje_actividades_aprobado' => $this->faker->randomFloat(),
            'ciclo_lectivo' => $this->faker->randomNumber(),

            'proceso_id' => Proceso::factory(),
        ];
    }
}
