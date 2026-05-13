<?php

namespace Database\Factories;

use App\Models\Factura;
use App\Models\Pedido;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacturaFactory extends Factory
{
    protected $model = Factura::class;

    public function definition(): array
    {
        return [
            'pedido_id' => Pedido::factory(),
            'numero_factura' => 'FAC-' . fake()->unique()->numerify('####'),
            'subtotal' => fake()->randomFloat(2, 100, 5000),
            'total' => fake()->randomFloat(2, 119, 5950),
            'estado_pago' => fake()->randomElement(['pendiente', 'pagado', 'parcial']),
        ];
    }
}