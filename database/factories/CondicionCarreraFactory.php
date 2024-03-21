<?php

namespace Database\Factories;

use App\Models\CondicionCarrera;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CondicionCarreraFactory extends Factory
{
    protected $model = CondicionCarrera::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'nombre' => $this->faker->word(),
            'identificador' => $this->faker->word(),
            'habilitado' => $this->faker->boolean(),
        ];
    }
}
