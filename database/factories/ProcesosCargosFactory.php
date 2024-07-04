<?php

namespace Database\Factories;

use App\Models\Cargo;
use App\Models\Proceso;
use App\Models\ProcesosCargos;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProcesosCargosFactory extends Factory
{
    protected $model = ProcesosCargos::class;

    public function definition(): array
    {
        return [
            'cierre' => Carbon::now(),
            'operador_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'proceso_id' => Proceso::factory(),
            'cargo_id' => Cargo::factory(),
        ];
    }
}
