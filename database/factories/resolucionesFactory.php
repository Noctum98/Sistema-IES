<?php

namespace Database\Factories;

use App\Models\Estados;
use App\Models\Resoluciones;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class resolucionesFactory extends Factory
{
    protected $model = Resoluciones::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'title' => $this->faker->word(),
            'duration' => $this->faker->randomNumber(),
            'resolution' => $this->faker->word(),
            'type' => $this->faker->word(),
            'vaccines' => $this->faker->word(),

            'estados_id' => Estados::factory(),
        ];
    }
}
