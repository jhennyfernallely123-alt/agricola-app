<?php

namespace Database\Factories;

use App\Models\SistemaRiego;
use Illuminate\Database\Eloquent\Factories\Factory;

class SistemaRiegoFactory extends Factory
{
    protected $model = SistemaRiego::class;

    public function definition(): array
    {
        return [
            'tipo' => fake()->randomElement(['Aspersión', 'Goteo', 'Gravedad', 'Microaspersión', 'Exudación']),
            'fuente' => fake()->randomElement(['Pozo profundo', 'Río', 'Embalse', 'Aguas lluvias', 'Acueducto']),
        ];
    }
}
