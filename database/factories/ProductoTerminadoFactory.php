<?php

namespace Database\Factories;

use App\Models\ProductoTerminado;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoTerminadoFactory extends Factory
{
    protected $model = ProductoTerminado::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->randomElement(['Tomate', 'Lechuga', 'Uva', 'Mora', 'Manzana', 'Zanahoria', 'Cebolla Larga', 'Cebolla de Huevo', 'Yuca', 'Repollo', 'Ajo']),
            'variedad' => fake()->randomElement(['Premium', 'Estándar', 'Económico']),
            'presentacion' => fake()->randomElement(['Bolsa 1kg', 'Caja 5kg', 'Saco 25kg', 'Canasta 10kg']),
            'lote' => 'L-' . fake()->unique()->numerify('####'),
            'calidad' => fake()->randomElement(['Premium', 'Primera', 'Segunda']),
            'fecha_cosecha' => fake()->date(),
        ];
    }
}