<?php

namespace Database\Factories;

use App\Models\AdminManager;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AdminManagerFactory extends Factory
{
    protected $model = AdminManager::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'model' => $this->faker->word(),
            'name' => $this->faker->name(),
            'link' => $this->faker->url(),
            'enabled' => $this->faker->boolean(),
            'icon' => $this->faker->word(),
        ];
    }
}
