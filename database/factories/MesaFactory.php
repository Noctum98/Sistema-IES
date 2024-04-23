<?php

namespace Database\Factories;

use App\Models\Comision;
use App\Models\Mesa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MesaFactory extends Factory
{
    protected $model = Mesa::class;

    public function definition(): array
    {
        return [
            'folio' => $this->faker->word(),
            'libro' => $this->faker->word(),
            'cierre_profesor' => $this->faker->boolean(),
            'fecha_cierre_profesor' => $this->faker->word(),
            'libro_segundo' => $this->faker->word(),
            'folio_segundo' => $this->faker->word(),
            'cierre_profesor_segundo' => $this->faker->boolean(),
            'fecha_cierre_profesor_segundo' => $this->faker->word(),
            'visible' => $this->faker->boolean(),

            'comision_id' => Comision::factory(),
            'presidente_id' => User::factory(),
            'primer_vocal_id' => User::factory(),
            'segundo_vocal_id' => User::factory(),
            'presidente_segundo_id' => User::factory(),
            'primer_vocal_segundo_id' => User::factory(),
            'segundo_vocal_segundo_id' => User::factory(),
        ];
    }
}
