<?php

namespace Database\Factories;

use App\Models\Nota;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NotaFactory extends Factory
{
    protected $model = Nota::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'valor' => $this->faker->word(),
            'min' => $this->faker->randomNumber(),
            'max' => $this->faker->randomNumber(),
            'year' => $this->faker->randomNumber(),
        ];
    }
}
