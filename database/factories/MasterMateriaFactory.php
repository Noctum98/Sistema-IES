<?php

namespace Database\Factories;

use App\Models\MasterMateria;
use App\Models\Regimen;
use App\Models\Resoluciones;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MasterMateriaFactory extends Factory
{
    protected $model = MasterMateria::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'year' => $this->faker->randomNumber(),
            'field_stage' => $this->faker->boolean(),
            'delayed_closing' => $this->faker->boolean(),

            'resoluciones_id' => Resoluciones::factory(),
            'regimen_id' => Regimen::factory(),
        ];
    }
}
