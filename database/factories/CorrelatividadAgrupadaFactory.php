<?php

namespace Database\Factories;

use App\Models\CorrelatividadAgrupada;
use App\Models\Resoluciones;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CorrelatividadAgrupadaFactory extends Factory
{
    protected $model = CorrelatividadAgrupada::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'Name' => $this->faker->name(),
            'Description' => $this->faker->text(),
            'identificador' => $this->faker->word(),
            'resoluciones_id' => Resoluciones::factory(),
            'user_id' => User::factory(),
        ];
    }
}
