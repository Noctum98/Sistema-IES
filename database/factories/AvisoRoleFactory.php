<?php

namespace Database\Factories;

use App\Models\AvisoRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AvisoRoleFactory extends Factory
{
    protected $model = AvisoRole::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
