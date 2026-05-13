<?php

namespace Database\Factories;

use App\Models\Parcela;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParcelaFactory extends Factory
{
    protected $model = Parcela::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->word() . ' ' . fake()->randomElement(['Norte', 'Sur', 'Este', 'Oeste', 'Central']),
            'area' => fake()->randomFloat(2, 1, 100),
            'potencial_productivo' => fake()->randomElement(['Alto', 'Medio', 'Bajo']),
        ];
    }
}