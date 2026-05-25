<?php

namespace Database\Factories;

use App\Models\PlanCultivo;
use App\Models\Cultivo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanCultivoFactory extends Factory
{
    protected $model = PlanCultivo::class;

    public function definition(): array
    {
        return [
            'cultivo_id' => Cultivo::factory(),
            'fecha_inicio' => fake()->date(),
            'fecha_fin_prevista' => fake()->dateTimeBetween('+1 month', '+6 months')->format('Y-m-d'),
            'objetivo_produccion' => fake()->randomFloat(2, 100, 10000),
        ];
    }
}
