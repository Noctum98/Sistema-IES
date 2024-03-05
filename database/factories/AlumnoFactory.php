<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AlumnoFactory extends Factory
{
    protected $model = Alumno::class;

    public function definition(): array
    {
        return [
            'año' => $this->faker->randomNumber(),
            'nombres' => $this->faker->word(),
            'apellidos' => $this->faker->word(),
            'email' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->word(),
            'telefono_fijo' => $this->faker->word(),
            'dni' => $this->faker->word(),
            'cuil' => $this->faker->word(),
            'imagen' => $this->faker->word(),
            'fecha' => $this->faker->word(),
            'edad' => $this->faker->word(),
            'genero' => $this->faker->word(),
            'regularidad' => $this->faker->word(),
            'nacionalidad' => $this->faker->word(),
            'provincia' => $this->faker->word(),
            'localidad' => $this->faker->word(),
            'calle' => $this->faker->word(),
            'n_calle' => $this->faker->word(),
            'barrio' => $this->faker->word(),
            'manzana' => $this->faker->word(),
            'casa' => $this->faker->randomNumber(),
            'codigo_postal' => $this->faker->postcode(),
            'estado_civil' => $this->faker->word(),
            'ocupacion' => $this->faker->word(),
            'g_sanguineo' => $this->faker->word(),
            'escolaridad' => $this->faker->word(),
            'condicion_s' => $this->faker->word(),
            'escuela_s' => $this->faker->word(),
            'materias_s' => $this->faker->word(),
            'titulo_s' => $this->faker->randomNumber(),
            'articulo_septimo' => $this->faker->word(),
            'privacidad' => $this->faker->randomNumber(),
            'poblacion_indigena' => $this->faker->randomNumber(),
            'discapacidad_mental' => $this->faker->word(),
            'discapacidad_intelectual' => $this->faker->word(),
            'discapacidad_visual' => $this->faker->word(),
            'discapacidad_auditiva' => $this->faker->word(),
            'discapacidad_motriz' => $this->faker->word(),
            'acompañamiento_motriz' => $this->faker->word(),
            'matriculacion' => $this->faker->word(),
            'pase' => $this->faker->word(),
            'fecha_primera_acreditacion' => $this->faker->word(),
            'fecha_ultima_acreditacion' => $this->faker->word(),
            'legajo_completo' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'comision_id' => $this->faker->randomNumber(),
            'cohorte' => $this->faker->word(),
            'active' => $this->faker->randomNumber(),
            'aprobado' => $this->faker->word(),
            'operador_id' => $this->faker->randomNumber(),
            'domicilio' => $this->faker->word(),

            'user_id' => User::factory(),
        ];
    }
}
