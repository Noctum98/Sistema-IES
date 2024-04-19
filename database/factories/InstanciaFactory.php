<?php

namespace Database\Factories;

use App\Models\Instancia;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstanciaFactory extends Factory
{
    protected $model = Instancia::class;

    public function definition(): array
    {
        return [
            'cierre' => $this->faker->boolean(),
            'año' => $this->faker->randomNumber(),
            'segundo_llamado' => $this->faker->boolean(),
            'general' => $this->faker->boolean(),
        ];
    }
}
