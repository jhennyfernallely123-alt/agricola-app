<?php

namespace Database\Factories;

use App\Models\ControlPlagasEnfermedades;
use App\Models\Cultivo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ControlPlagasEnfermedadesFactory extends Factory
{
    protected $model = ControlPlagasEnfermedades::class;

    public function definition(): array
    {
        return [
            'cultivo_id' => Cultivo::factory(),
            'tipo' => fake()->randomElement(['Plaga', 'Enfermedad', 'Maleza']),
            'nombre' => fake()->randomElement(['Mosca blanca', 'Ácaros', 'Mildiu', 'Royas', 'Pulgones', 'Gusano cogollero']),
            'fecha_deteccion' => fake()->date(),
            'tratamiento_aplicado' => fake()->sentence(5),
        ];
    }
}
