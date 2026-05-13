<?php

namespace Database\Factories;

use App\Models\InventarioProductos;
use App\Models\ProductoTerminado;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventarioProductosFactory extends Factory
{
    protected $model = InventarioProductos::class;

    public function definition(): array
    {
        return [
            'producto_id' => ProductoTerminado::factory(),
            'cantidad_disponible' => fake()->randomFloat(2, 0, 1000),
            'ubicacion' => fake()->randomElement(['Almacén A', 'Almacén B', 'Cámara Fría', 'Zona de Carga']),
        ];
    }
}