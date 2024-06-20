<?php

namespace Database\Factories;

use App\Models\TipoMateria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TipoMateriaFactory extends Factory
{
    protected $model = TipoMateria::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'identificador' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
