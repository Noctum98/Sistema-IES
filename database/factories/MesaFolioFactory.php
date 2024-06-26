<?php

namespace Database\Factories;

use App\Models\LibroDigital;
use App\Models\MasterMateria;
use App\Models\Mesa;
use App\Models\MesaFolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MesaFolioFactory extends Factory
{
    protected $model = MesaFolio::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'numero' => $this->faker->randomNumber(),
            'turno' => $this->faker->word(),
            'fecha' => Carbon::now(),
            'aprobados' => $this->faker->randomNumber(),
            'desaprobados' => $this->faker->randomNumber(),
            'ausentes' => $this->faker->randomNumber(),
            'use' => $this->faker->word(),

            'libro_digital_id' => LibroDigital::factory(),
            'mesa_id' => Mesa::factory(),
            'master_materia_id' => MasterMateria::factory(),
            'vocal_1_id' => User::factory(),
            'vocal_2_id' => User::factory(),
            'coordinador_id' => User::factory(),
            'operador_id' => User::factory(),
            'presidente_id' => User::factory(),
        ];
    }
}
