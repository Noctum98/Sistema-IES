<?php

namespace Database\Factories;

use App\Models\Regimen;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RegimenFactory extends Factory
{
    protected $model = Regimen::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'identifier' => $this->faker->word(),
        ];
    }
}
