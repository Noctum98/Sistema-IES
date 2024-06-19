<?php

namespace Database\Factories;

use App\Models\Libro;
use App\Models\Mesa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LibroFactory extends Factory
{
    protected $model = Libro::class;

    public function definition(): array
    {
        return [
            'llamado' => $this->faker->randomNumber(),
            'numero' => $this->faker->randomNumber(),
            'folio' => $this->faker->randomNumber(),
            'orden' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'mesa_id' => Mesa::factory(),
        ];
    }
}
