<?php

namespace Database\Factories;

use App\Models\LibroPapel;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LibroPapelFactory extends Factory
{
    protected $model = LibroPapel::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'number' => $this->faker->randomNumber(),
            'fecha_inicio' => Carbon::now(),
            'acta_inicio' => $this->faker->word(),
            'roman' => $this->faker->word(),

            'sede_id' => Sede::factory(),
            'user_id' => User::factory(),
        ];
    }
}
