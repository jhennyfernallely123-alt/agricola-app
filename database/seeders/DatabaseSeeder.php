<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database con datos realistas colombianos.
     *
     * Ejecuta los tres módulos en orden para respetar dependencias foráneas:
     * 1. Gestión de Cultivo (parcelas, cultivos, etc.)
     * 2. Venta y Distribución (clientes, pedidos, etc.)
     * 3. Gestión de Recursos (personal, maquinaria, etc.)
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GestionCultivoSeeder::class,
            VentaDistribucionSeeder::class,
            GestionRecursosSeeder::class,
        ]);
    }
}
