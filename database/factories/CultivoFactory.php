<?php

namespace Database\Factories;

use App\Models\Cultivo;
use App\Models\Parcela;
use Illuminate\Database\Eloquent\Factories\Factory;

class CultivoFactory extends Factory
{
    protected $model = Cultivo::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->randomElement(['Tomate Cherry', 'Lechuga Romana', 'Uva Isabella', 'Fresa', 'Pimentón', 'Pepino', 'Sandía', 'Melón']),
            'variedad' => fake()->randomElement(['Híbrida', 'Orgánica', 'Tradicional', 'Transgénica']),
            'requerimientos' => fake()->sentence(8),
            'parcela_id' => Parcela::factory(),
        ];
    }
}
