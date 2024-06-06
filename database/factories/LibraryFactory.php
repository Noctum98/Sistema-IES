<?php

namespace Database\Factories;

use App\Library;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LibraryFactory extends Factory
{
    protected $model = Library::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'link' => $this->faker->url(),
            'orden' => $this->faker->numberBetween(0, 99),
        ];
    }
}
