<?php

namespace Database\Factories;

use App\Models\EtapaFenologica;
use App\Models\Cultivo;
use Illuminate\Database\Eloquent\Factories\Factory;

class EtapaFenologicaFactory extends Factory
{
    protected $model = EtapaFenologica::class;

    public function definition(): array
    {
        return [
            'cultivo_id' => Cultivo::factory(),
            'nombre' => fake()->randomElement(['Germinación', 'Crecimiento vegetativo', 'Floración', 'Fructificación', 'Maduración', 'Cosecha']),
            'fecha_inicio' => fake()->date(),
            'requerimientos_especificos' => fake()->sentence(6),
        ];
    }
}
