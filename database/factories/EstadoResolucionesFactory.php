<?php

namespace Database\Factories;

use App\Models\EstadoResoluciones;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EstadoResolucionesFactory extends Factory
{
    protected $model = EstadoResoluciones::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'identifier' => $this->faker->word(),
            'disabled' => $this->faker->boolean(),
        ];
    }
}
