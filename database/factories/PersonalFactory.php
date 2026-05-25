<?php

namespace Database\Factories;

use App\Models\Personal;
use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalFactory extends Factory
{
    protected $model = Personal::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'habilidades' => fake()->randomElement(['Siembra', 'Riego', 'Cosecha', 'Poda', 'Fertilización', 'Mantenimiento']),
            'contrato' => fake()->date(),
        ];
    }
}
