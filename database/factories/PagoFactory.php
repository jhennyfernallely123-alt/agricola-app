<?php

namespace Database\Factories;

use App\Models\Pago;
use App\Models\Factura;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagoFactory extends Factory
{
    protected $model = Pago::class;

    public function definition(): array
    {
        return [
            'factura_id' => Factura::factory(),
            'monto' => fake()->randomFloat(2, 100, 5000),
            'fecha' => fake()->date(),
            'metodo_pago' => fake()->randomElement(['efectivo', 'transferencia', 'tarjeta', 'cheque']),
        ];
    }
}