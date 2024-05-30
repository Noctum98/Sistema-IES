<?php

namespace Database\Factories;

use App\Models\AgrupadaMateria;
use App\Models\CorrelatividadAgrupada;
use App\Models\MasterMateria;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AgrupadaMateriaFactory extends Factory
{
    protected $model = AgrupadaMateria::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'disabled' => $this->faker->boolean(),

            'correlatividad_agrupada_id' => CorrelatividadAgrupada::factory(),
            'master_materia_id' => MasterMateria::factory(),
            'user_id' => User::factory(),
        ];
    }
}
