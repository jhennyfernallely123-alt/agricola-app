<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'fecha' => fake()->date(),
            'estado' => fake()->randomElement(['pendiente', 'en_proceso', 'enviado', 'entregado', 'cancelado']),
        ];
    }
}