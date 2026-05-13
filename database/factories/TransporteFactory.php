<?php

namespace Database\Factories;

use App\Models\Transporte;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransporteFactory extends Factory
{
    protected $model = Transporte::class;

    public function definition(): array
    {
        return [
            'tipo' => fake()->randomElement(['camión', 'camioneta', 'furgón', 'tractor']),
            'placa' => strtoupper(fake()->bothify('???-###')),
            'capacidad' => fake()->numberBetween(500, 10000),
        ];
    }
}