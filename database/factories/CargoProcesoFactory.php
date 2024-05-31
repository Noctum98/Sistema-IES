<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CargoProcesoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(), // ajusta aquí de conveniencia, por ejemplo, puedes obtener un número de usuario realmente existente
            'cargo_id' => $this->faker->randomNumber(), // ajusta aquí de conveniencia
            'proceso_id' => $this->faker->randomNumber(), // ajusta aquí de conveniencia
            'ciclo_lectivo' => $this->faker->year,
            'cantidad_tp' => $this->faker->randomNumber(),
            'suma_tp' => $this->faker->randomNumber(),
            'nota_tp' => $this->faker->randomFloat(2, 0, 10), // generar flotante aleatorio entre 0 y 10 con precisión de 2 decimales
            'cantidad_ps' => $this->faker->randomNumber(),
            'suma_ps' => $this->faker->randomNumber(),
            'nota_ps' => $this->faker->randomFloat(2, 0, 10), // generar flotante aleatorio entre 0 y 10 con precisión de 2 decimales
            'nota_cargo' => $this->faker->randomFloat(2, 0, 10), // generar flotante aleatorio entre 0 y 10 con precisión de 2 decimales
            'nota_ponderada' => $this->faker->randomFloat(2, 0, 10), // generar flotante aleatorio entre 0 y 10 con precisión de 2 decimales
            'porcentaje_asistencia' => $this->faker->numberBetween(0, 100), // generar número aleatorio entre 0 y 100
        ];
    }
}
