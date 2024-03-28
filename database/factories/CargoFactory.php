<?php

namespace Database\Factories;

use App\Models\Cargo;
use App\Models\Carrera;
use App\Models\TipoMateria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CargoFactory extends Factory
{
    protected $model = Cargo::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'carrera_id' => Carrera::factory(),
            'tipo_materia_id' => TipoMateria::factory(),
        ];
    }
}
