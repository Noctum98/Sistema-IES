<?php

namespace Database\Factories;

use App\Models\CondicionMateria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CondicionMateriaFactory extends Factory
{
    protected $model = CondicionMateria::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'identificador' => $this->faker->word(),
            'habilitado' => $this->faker->boolean(),
            'operador_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
