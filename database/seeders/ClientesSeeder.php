<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClientesSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nombre' => 'Comercializadora Agrícola del Valle',
                'contacto' => 'ventas@comercialvalle.com',
                'canal_distribucion' => 'mayorista',
            ],
            [
                'nombre' => 'Supermercados La Cosecha',
                'contacto' => 'compras@lacosecha.com',
                'canal_distribucion' => 'minorista',
            ],
            [
                'nombre' => 'Exportaciones Andinas S.A.',
                'contacto' => 'info@exportandinas.com',
                'canal_distribucion' => 'exportación',
            ],
            [
                'nombre' => 'Restaurante El Campestre',
                'contacto' => 'carlos@elcampestre.com',
                'canal_distribucion' => 'directo',
            ],
            [
                'nombre' => 'Cooperativa Agrícola Regional',
                'contacto' => 'coop.regional@email.com',
                'canal_distribucion' => 'mayorista',
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
