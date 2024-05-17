<?php

namespace Database\Factories;

use App\Models\TipoCarrera;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TipoCarreraFactory extends Factory
{
    protected $model = TipoCarrera::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
        ];
    }
}
