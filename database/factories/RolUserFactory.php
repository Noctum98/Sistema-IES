<?php

namespace Database\Factories;

use App\Models\RolUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RolUserFactory extends Factory
{
    protected $model = RolUser::class;

    public function definition(): array
    {
        return [
            'rol_id' => $this->faker->randomNumber(),
            'user_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
