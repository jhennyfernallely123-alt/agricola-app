<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Personal;
use App\Models\Maquinaria;
use App\Models\MantenimientoMaquinaria;
use App\Models\Proveedor;
use App\Models\Presupuesto;
use App\Models\Gasto;
use App\Models\Ingreso;
use App\Models\InformeFinanciero;
use App\Models\Pedido;
use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GestionRecursosSeeder extends Seeder
{
    /**
     * Seed del módulo Gestión de Recursos con datos realistas colombianos.
     */
    public function run(): void
    {
        // ====================================================================
        // 1. ROLES — Cargos típicos de una hacienda agrícola
        // ====================================================================
        $roles = [
            ['nombre' => 'Administrador',      'descripcion' => 'Gestión general de la hacienda, toma de decisiones estratégicas.'],
            ['nombre' => 'Jefe de Cultivo',    'descripcion' => 'Supervisa las labores agrícolas, planifica siembras y cosechas.'],
            ['nombre' => 'Tractorista',        'descripcion' => 'Opera maquinaria agrícola para preparación de suelos.'],
            ['nombre' => 'Operario de Campo',   'descripcion' => 'Realiza labores de siembra, mantenimiento y cosecha.'],
            ['nombre' => 'Especialista en Riego', 'descripcion' => 'Mantiene y opera los sistemas de riego de la finca.'],
            ['nombre' => 'Conductor',          'descripcion' => 'Transporta productos a puntos de venta y distribución.'],
            ['nombre' => 'Auxiliar Contable',  'descripcion' => 'Gestiona gastos, ingresos y reportes financieros.'],
        ];

        foreach ($roles as $data) {
            Rol::firstOrCreate(['nombre' => $data['nombre']], $data);
        }

        $this->command->info('Roles creados: ' . Rol::count());

        // ====================================================================
        // 2. PERSONAL — Empleados con nombres colombianos realistas
        // ====================================================================
        $personal = [
            ['nombre' => 'Juan Pablo García',          'rol_id' => 1, 'habilidades' => 'Administración agropecuaria, liderazgo de equipos, planificación estratégica',                    'contrato' => '2023-01-10'],
            ['nombre' => 'María Fernanda Gómez',       'rol_id' => 2, 'habilidades' => 'Manejo de cultivos, sistemas de riego, control fitosanitario y fertilización',                   'contrato' => '2023-03-15'],
            ['nombre' => 'Carlos Arturo Martínez',     'rol_id' => 4, 'habilidades' => 'Siembra, cosecha, poda de frutales, manejo de herbicidas',                                        'contrato' => '2024-02-01'],
            ['nombre' => 'Ana Lucía Restrepo',          'rol_id' => 4, 'habilidades' => 'Cosecha selectiva, manejo poscosecha, empaque y clasificación de frutos',                       'contrato' => '2024-06-10'],
            ['nombre' => 'Diego Alejandro Muñoz',      'rol_id' => 5, 'habilidades' => 'Instalación y mantenimiento de sistemas de riego, manejo de bombas y motores',                   'contrato' => '2024-01-20'],
            ['nombre' => 'Luis Fernando Rodríguez',    'rol_id' => 3, 'habilidades' => 'Operación de tractores, cosechadoras y rastrillos. Mantenimiento básico de maquinaria',           'contrato' => '2023-08-05'],
            ['nombre' => 'Andrés Felipe López',        'rol_id' => 6, 'habilidades' => 'Conducción de camiones de carga pesada, rutas de distribución, logística de entregas',           'contrato' => '2024-04-12'],
            ['nombre' => 'Paola Andrea Ramírez',       'rol_id' => 7, 'habilidades' => 'Contabilidad agrícola, elaboración de informes financieros, control de gastos e ingresos',        'contrato' => '2024-09-01'],
            ['nombre' => 'José David Torres',          'rol_id' => 4, 'habilidades' => 'Fertilización, control de plagas, aplicación de agroquímicos con equipo especializado',          'contrato' => '2024-11-15'],
            ['nombre' => 'Laura Cristina Mendoza',    'rol_id' => 4, 'habilidades' => 'Manejo de viveros, producción de plántulas, injertación y propagación vegetativa',              'contrato' => '2025-02-01'],
            ['nombre' => 'Ricardo Antonio Morales',    'rol_id' => 3, 'habilidades' => 'Operación de retroexcavadora, tractor de oruga y bulldozer para adecuación de terrenos',         'contrato' => '2024-05-20'],
            ['nombre' => 'Sandra Milena Ortiz',        'rol_id' => 4, 'habilidades' => 'Clasificación y empaque de productos agrícolas, control de calidad, manejo de cámaras frías',   'contrato' => '2025-01-15'],
        ];

        foreach ($personal as $data) {
            Personal::updateOrCreate(
                ['nombre' => $data['nombre']],
                $data
            );
        }

        $this->command->info('Personal creado: ' . Personal::count());

        // ====================================================================
        // 3. MAQUINARIA — Equipos agrícolas
        // ====================================================================
        $maquinarias = [
            ['nombre' => 'Tractor John Deere 5075E',   'tipo' => 'Tractor',       'mantenimiento' => 'Cambio de aceite cada 250 horas. Revisión de filtros cada 100 horas.'],
            ['nombre' => 'Tractor Ford 6610',          'tipo' => 'Tractor',       'mantenimiento' => 'Mantenimiento preventivo cada 300 horas. Revisión de sistema hidráulico.'],
            ['nombre' => 'Cosechadora de Hortalizas',  'tipo' => 'Cosechadora',   'mantenimiento' => 'Lubricación diaria de cuchillas. Afilado semanal. Revisión de bandas transportadoras.'],
            ['nombre' => 'Rastrillo de Discos 24',     'tipo' => 'Implemento',    'mantenimiento' => 'Engrase de rodamientos cada 50 horas. Cambio de discos según desgaste.'],
            ['nombre' => 'Fumigadora de Arrastre 600L','tipo' => 'Fumigadora',    'mantenimiento' => 'Limpieza de tanque y boquillas después de cada uso. Calibración mensual.'],
            ['nombre' => 'Motobomba 5HP',              'tipo' => 'Bomba',         'mantenimiento' => 'Cambio de aceite cada 100 horas. Limpieza de filtro de succión.'],
            ['nombre' => 'Tractor Kubota M7060',       'tipo' => 'Tractor',       'mantenimiento' => 'Mantenimiento cada 200 horas. Revisión de sistema de dirección y frenos.'],
            ['nombre' => 'Sembradora Neumática 4 hileras','tipo' => 'Sembradora', 'mantenimiento' => 'Limpieza de discos dosificadores. Calibración de profundidad de siembra.'],
        ];

        foreach ($maquinarias as $data) {
            Maquinaria::firstOrCreate(['nombre' => $data['nombre']], $data);
        }

        $this->command->info('Maquinaria creada: ' . Maquinaria::count());

        // ====================================================================
        // 4. MANTENIMIENTO DE MAQUINARIA
        // ====================================================================
        $mantenimientos = [
            ['maquinaria_id' => 1, 'fecha' => '2026-01-15', 'tipo' => 'Preventivo', 'costo' => 450000.00],
            ['maquinaria_id' => 1, 'fecha' => '2026-03-20', 'tipo' => 'Preventivo', 'costo' => 380000.00],
            ['maquinaria_id' => 2, 'fecha' => '2026-02-10', 'tipo' => 'Correctivo', 'costo' => 1200000.00],
            ['maquinaria_id' => 3, 'fecha' => '2026-04-01', 'tipo' => 'Preventivo', 'costo' => 280000.00],
            ['maquinaria_id' => 5, 'fecha' => '2026-03-05', 'tipo' => 'Correctivo', 'costo' => 650000.00],
            ['maquinaria_id' => 6, 'fecha' => '2026-01-20', 'tipo' => 'Preventivo', 'costo' => 120000.00],
            ['maquinaria_id' => 7, 'fecha' => '2026-04-15', 'tipo' => 'Preventivo', 'costo' => 520000.00],
        ];

        foreach ($mantenimientos as $data) {
            try {
                MantenimientoMaquinaria::create($data);
            } catch (\Exception $e) {
                // Ignorar duplicados
            }
        }

        $this->command->info('Mantenimientos creados: ' . MantenimientoMaquinaria::count());

        // ====================================================================
        // 5. PROVEEDORES
        // ====================================================================
        $proveedores = [
            ['nombre' => 'Agroinsumos del Valle Ltda.',     'contacto' => 'ventas@agroinsumosvalle.com',      'contrato' => 'Contrato anual de suministro de fertilizantes e insumos agrícolas.'],
            ['nombre' => 'Semillas Premium Colombia SAS',   'contacto' => 'pedidos@semillaspremium.com.co',   'contrato' => 'Convenio de distribución exclusiva de semillas híbridas.'],
            ['nombre' => 'Maquinaria Agrícola del Pacífico', 'contacto' => 'repuestos@maquinariapacifico.com', 'contrato' => 'Contrato de mantenimiento preventivo trimestral.'],
            ['nombre' => 'Fertilizantes del Campo E.U.',    'contacto' => 'info@fertcampo.com',               'contrato' => 'Proveedor principal de fertilizantes NPK y enmiendas.'],
            ['nombre' => 'Envases y Empaques del Campo',   'contacto' => 'empaques@envasescampo.com',         'contrato' => 'Suministro mensual de bolsas, canastas y cajas para empaque.'],
            ['nombre' => 'Transportes Fríos del Sur',      'contacto' => 'logistica@transfriosur.com',        'contrato' => 'Servicio de transporte refrigerado para distribución nacional.'],
            ['nombre' => 'Laboratorio Fitosanitario Ltda.', 'contacto' => 'analisis@labfitosanitario.com',    'contrato' => 'Análisis periódicos de suelo y diagnóstico fitosanitario.'],
        ];

        foreach ($proveedores as $data) {
            Proveedor::firstOrCreate(['nombre' => $data['nombre']], $data);
        }

        $this->command->info('Proveedores creados: ' . Proveedor::count());

        // ====================================================================
        // 6. PRESUPUESTOS
        // ====================================================================
        $presupuestos = [
            ['nombre' => 'Presupuesto Q1 2026',        'fecha_inicio' => '2026-01-01', 'fecha_fin' => '2026-03-31', 'monto_total' => 45000000.00],
            ['nombre' => 'Presupuesto Q2 2026',        'fecha_inicio' => '2026-04-01', 'fecha_fin' => '2026-06-30', 'monto_total' => 60000000.00],
            ['nombre' => 'Cosecha Primer Semestre 2026', 'fecha_inicio' => '2026-01-01', 'fecha_fin' => '2026-06-30', 'monto_total' => 95000000.00],
            ['nombre' => 'Mantenimiento Maquinaria 2026', 'fecha_inicio' => '2026-01-01', 'fecha_fin' => '2026-12-31', 'monto_total' => 8000000.00],
            ['nombre' => 'Adecuación Sistemas de Riego',  'fecha_inicio' => '2026-05-01', 'fecha_fin' => '2026-07-31', 'monto_total' => 15000000.00],
        ];

        foreach ($presupuestos as $data) {
            Presupuesto::firstOrCreate(['nombre' => $data['nombre']], $data);
        }

        $this->command->info('Presupuestos creados: ' . Presupuesto::count());

        // ====================================================================
        // 7. GASTOS
        // ====================================================================
        $gastos = [
            ['concepto' => 'Compra de fertilizante NPK 15-15-15 (50 bultos)',        'monto' => 6250000.00,  'fecha' => '2026-01-20', 'proveedor_id' => 1],
            ['concepto' => 'Adquisición de semillas de tomate híbrido (10 000 unid)', 'monto' => 2400000.00,  'fecha' => '2026-01-25', 'proveedor_id' => 2],
            ['concepto' => 'Mantenimiento tractor John Deere — cambio de aceite',     'monto' => 450000.00,   'fecha' => '2026-01-15', 'proveedor_id' => 3],
            ['concepto' => 'Compra de urea agrícola (20 bultos x 50kg)',              'monto' => 3800000.00,  'fecha' => '2026-02-10', 'proveedor_id' => 4],
            ['concepto' => 'Empaques para cosecha (500 bolsas, 100 canastas)',        'monto' => 1850000.00,  'fecha' => '2026-02-20', 'proveedor_id' => 5],
            ['concepto' => 'Transporte refrigerado — Pedido Frutas del Campo SAS',    'monto' => 1200000.00,  'fecha' => '2026-03-05', 'proveedor_id' => 6],
            ['concepto' => 'Análisis de suelo - Parcelas La Esperanza y El Porvenir', 'monto' => 380000.00,   'fecha' => '2026-01-10', 'proveedor_id' => 7],
            ['concepto' => 'Jabón potásico y aceite de neem para control de plagas',  'monto' => 520000.00,   'fecha' => '2026-02-28', 'proveedor_id' => 1],
            ['concepto' => 'Nómina semanal personal de campo (12 empleados)',         'monto' => 4800000.00,  'fecha' => '2026-03-15', 'proveedor_id' => null],
            ['concepto' => 'Repuestos tractor Ford 6610 — bomba hidráulica',          'monto' => 1200000.00,  'fecha' => '2026-02-10', 'proveedor_id' => 3],
            ['concepto' => 'Servicio de energía eléctrica bombeo de agua',            'monto' => 680000.00,   'fecha' => '2026-03-30', 'proveedor_id' => null],
        ];

        foreach ($gastos as $data) {
            try {
                Gasto::create($data);
            } catch (\Exception $e) {
                // Ignorar duplicados
            }
        }

        $this->command->info('Gastos creados: ' . Gasto::count());

        // ====================================================================
        // 8. INGRESOS
        // ====================================================================
        // Crear pedidos de referencia si no existen (necesario para ingresos con pedido_id)
        $ingresos = [
            ['fuente' => 'Venta de tomate — Pedido Carlos Martínez',         'monto' => 1487500.00, 'fecha' => '2026-04-05', 'pedido_id' => 1],
            ['fuente' => 'Venta de mora y fresa — Pedido Andrés López',      'monto' => 1166200.00, 'fecha' => '2026-04-15', 'pedido_id' => 2],
            ['fuente' => 'Venta a Frutas del Campo SAS — Pedido mayorista',  'monto' => 2499000.00, 'fecha' => '2026-04-25', 'pedido_id' => 3],
            ['fuente' => 'Venta directa en plaza de mercado — Lechuga',      'monto' => 350000.00,  'fecha' => '2026-05-02', 'pedido_id' => null],
            ['fuente' => 'Venta de aguacate Hass — Pedido exportación',      'monto' => 3689000.00, 'fecha' => '2026-05-10', 'pedido_id' => 5],
            ['fuente' => 'Venta de fresa — Supermercados El Campesino',      'monto' => 890000.00,  'fecha' => '2026-05-12', 'pedido_id' => 6],
            ['fuente' => 'Venta de cilantro y lechuga — Restaurante La Cosecha', 'monto' => 280000.00, 'fecha' => '2026-05-16', 'pedido_id' => null],
        ];

        foreach ($ingresos as $data) {
            try {
                Ingreso::create($data);
            } catch (\Exception $e) {
                // Ignorar duplicados
            }
        }

        $this->command->info('Ingresos creados: ' . Ingreso::count());

        // ====================================================================
        // 9. INFORMES FINANCIEROS
        // ====================================================================
        $informes = [
            [
                'tipo' => 'Mensual',
                'fecha_inicio' => '2026-01-01',
                'fecha_fin' => '2026-01-31',
                'ingresos_totales' => 8500000.00,
                'gastos_totales' => 6200000.00,
                'rentabilidad' => 2300000.00,
            ],
            [
                'tipo' => 'Mensual',
                'fecha_inicio' => '2026-02-01',
                'fecha_fin' => '2026-02-28',
                'ingresos_totales' => 9200000.00,
                'gastos_totales' => 7150000.00,
                'rentabilidad' => 2050000.00,
            ],
            [
                'tipo' => 'Mensual',
                'fecha_inicio' => '2026-03-01',
                'fecha_fin' => '2026-03-31',
                'ingresos_totales' => 12500000.00,
                'gastos_totales' => 8200000.00,
                'rentabilidad' => 4300000.00,
            ],
            [
                'tipo' => 'Trimestral',
                'fecha_inicio' => '2026-01-01',
                'fecha_fin' => '2026-03-31',
                'ingresos_totales' => 30200000.00,
                'gastos_totales' => 21550000.00,
                'rentabilidad' => 8650000.00,
            ],
        ];

        foreach ($informes as $data) {
            try {
                InformeFinanciero::create($data);
            } catch (\Exception $e) {
                // Ignorar duplicados
            }
        }

        $this->command->info('Informes financieros creados: ' . InformeFinanciero::count());
    }
}
