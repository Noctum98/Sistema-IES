<?php

namespace Database\Factories;

use App\Models\OldLibro;
use App\Models\Resoluciones;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OldLibroFactory extends Factory
{
    protected $model = OldLibro::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'acta_inicio' => $this->faker->word(),
            'number' => $this->faker->randomNumber(),
            'fecha_inicio' => Carbon::now(),
            'resolucion_original' => $this->faker->word(),
            'observaciones' => $this->faker->word(),

            'resoluciones_id' => Resoluciones::factory(),
            'sede_id' => Sede::factory(),
            'operador_id' => User::factory(),
            'user_id' => User::factory(),
        ];
    }
}
