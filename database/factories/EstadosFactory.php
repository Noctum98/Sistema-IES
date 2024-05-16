<?php

namespace Database\Factories;

use App\Models\Estados;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EstadosFactory extends Factory
{
    protected $model = Estados::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'identificador' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_action_id' => $this->faker->randomNumber(),
            'regularidad' => $this->faker->word(),
        ];
    }
}
