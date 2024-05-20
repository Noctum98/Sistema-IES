<?php

namespace Database\Factories;

use App\Models\EstadoCarrera;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EstadoCarreraFactory extends Factory
{
    protected $model = EstadoCarrera::class;

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
