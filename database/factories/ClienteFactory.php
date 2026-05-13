<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->company(),
            'contacto' => fake()->email(),
            'canal_distribucion' => fake()->randomElement(['directo', 'mayorista', 'minorista', 'exportación']),
        ];
    }
}