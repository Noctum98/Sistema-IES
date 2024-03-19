<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nota;

class NotaSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedByYear(2021, ['A', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], [-1, 0, 1, 20, 40, 60, 66, 72, 78, 84, 90, 96], [-1, 0, 19, 39, 59, 65, 71, 77, 83, 89, 95, 100]);
        $this->seedByYear(2024, ['A', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], [-1, 0, 16, 27, 38, 49, 60, 66, 77, 86, 96], [-1, 15, 26, 37, 48, 59, 65, 76, 85, 95, 100]);
    }

    private function seedByYear($year, array $valores, array $minValues, array $maxValues)
    {
        $size = sizeof($valores);
        for ($i = 0; $i < $size; $i++) {
            Nota::create([
                'valor' => $valores[$i],
                'min' => $minValues[$i],
                'max' => $maxValues[$i],
                'year' => $year
            ]);
        }
    }
}
