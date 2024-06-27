<?php

namespace Database\Factories;

use App\Models\ActaVolante;
use App\Models\Alumno;
use App\Models\FolioNota;
use App\Models\MesaFolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FolioNotaFactory extends Factory
{
    protected $model = FolioNota::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'orden' => $this->faker->randomNumber(),
            'permiso' => $this->faker->randomNumber(),
            'escrito' => $this->faker->randomNumber(),
            'oral' => $this->faker->randomNumber(),
            'definitiva' => $this->faker->randomNumber(),

            'operador_id' => User::factory(),
            'acta_volante_id' => ActaVolante::factory(),
            'mesa_folio_id' => MesaFolio::factory(),
            'alumno_id' => Alumno::factory(),
        ];
    }
}
