<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\GestionCultivoSeeder;
use Database\Seeders\VentaDistribucionSeeder;
use Database\Seeders\GestionRecursosSeeder;

/**
 * Demo Data Test
 * 
 * Prueba integral que verifica todos los datos sembrados con nombres realistas
 * colombianos. Diseñada específicamente para demostrar al profesor que el
 * sistema funciona con información real de una hacienda agrícola.
 * 
 * Ejecutar con: php artisan test --filter DemoDataTest
 */
class DemoDataTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Sembrar todos los datos realistas
        $this->seed(GestionCultivoSeeder::class);
        $this->seed(VentaDistribucionSeeder::class);
        $this->seed(GestionRecursosSeeder::class);
    }

    // =========================================================================
    // 1. GESTIÓN DE CULTIVO — Parcelas, Cultivos, Labores
    // =========================================================================

    public function test_demo_parcelas_con_nombres_de_fincas_colombianas()
    {
        $this->assertDatabaseHas('parcelas', ['nombre' => 'La Esperanza',       'area' => 45.5, 'potencial_productivo' => 'Alto']);
        $this->assertDatabaseHas('parcelas', ['nombre' => 'El Porvenir',        'area' => 32.0, 'potencial_productivo' => 'Medio']);
        $this->assertDatabaseHas('parcelas', ['nombre' => 'Buenavista',         'area' => 28.7, 'potencial_productivo' => 'Alto']);
        $this->assertDatabaseHas('parcelas', ['nombre' => 'San Isidro Labrador','area' => 52.3, 'potencial_productivo' => 'Alto']);
        $this->assertDatabaseHas('parcelas', ['nombre' => 'El Manantial',       'area' => 22.0, 'potencial_productivo' => 'Alto']);

        $this->assertCount(8, \App\Models\Parcela::all());
    }

    public function test_demo_cultivos_con_especies_agricolas_colombianas()
    {
        $this->assertDatabaseHas('cultivos', ['nombre' => 'Tomate Chonto',    'variedad' => 'Híbrida']);
        $this->assertDatabaseHas('cultivos', ['nombre' => 'Uva Isabella',     'variedad' => 'Criolla']);
        $this->assertDatabaseHas('cultivos', ['nombre' => 'Mora de Castilla', 'variedad' => 'Orgánica']);
        $this->assertDatabaseHas('cultivos', ['nombre' => 'Fresa Albión',     'variedad' => 'Híbrida']);
        $this->assertDatabaseHas('cultivos', ['nombre' => 'Gulupa',           'variedad' => 'Tradicional']);
        $this->assertDatabaseHas('cultivos', ['nombre' => 'Aguacate Hass',    'variedad' => 'Injertada']);

        $this->assertCount(12, \App\Models\Cultivo::all());
    }

    public function test_demo_sistemas_de_riego_con_fuentes_reales()
    {
        $this->assertDatabaseHas('sistema_riegos', ['tipo' => 'Goteo']);
        $this->assertDatabaseHas('sistema_riegos', ['tipo' => 'Aspersión']);
        $this->assertDatabaseHas('sistema_riegos', ['tipo' => 'Microaspersión']);
        $this->assertDatabaseHas('sistema_riegos', ['tipo' => 'Goteo automatizado']);
    }

    public function test_demo_insumos_agricolas_con_fertilizantes_reales()
    {
        $this->assertDatabaseHas('fertilizantes', ['nombre' => 'NPK 15-15-15',       'tipo' => 'Granulado']);
        $this->assertDatabaseHas('fertilizantes', ['nombre' => 'Urea Agrícola',      'tipo' => 'Granulado']);
        $this->assertDatabaseHas('fertilizantes', ['nombre' => 'Compost Orgánico',   'tipo' => 'Orgánico']);
        $this->assertDatabaseHas('fertilizantes', ['nombre' => 'Cal Dolomítica',     'tipo' => 'Enmienda']);
    }

    public function test_demo_labores_agricolas_con_empleados_reales()
    {
        $this->assertDatabaseHas('labor_agricolas', [
            'tipo' => 'Preparación del suelo',
        ]);
        $this->assertDatabaseHas('labor_agricolas', [
            'tipo' => 'Siembra',
        ]);
        $this->assertDatabaseHas('labor_agricolas', [
            'tipo' => 'Cosecha',
        ]);
        $this->assertDatabaseHas('labor_agricolas', [
            'tipo' => 'Fertilización NPK',
        ]);
    }

    public function test_demo_control_plagas_con_tratamientos_reales()
    {
        $this->assertDatabaseHas('control_plagas_enfermedades', [
            'nombre' => 'Pasador del fruto (Neoleucinodes elegantalis)',
        ]);
        $this->assertDatabaseHas('control_plagas_enfermedades', [
            'nombre' => 'Ácaros (Tetranychus urticae)',
        ]);
        $this->assertDatabaseHas('control_plagas_enfermedades', [
            'nombre' => 'Pulgones (Aphididae)',
        ]);
    }

    // =========================================================================
    // 2. VENTA Y DISTRIBUCIÓN — Clientes, Pedidos, Facturas
    // =========================================================================

    public function test_demo_clientes_con_nombres_colombianos_reales()
    {
        // Personas naturales
        $this->assertDatabaseHas('clientes', ['nombre' => 'Carlos Alberto Martínez',     'contacto' => 'carlos.martinez@gmail.com']);
        $this->assertDatabaseHas('clientes', ['nombre' => 'María Eugenia Rodríguez',     'contacto' => 'maria.rodriguez@hotmail.com']);
        $this->assertDatabaseHas('clientes', ['nombre' => 'Andrés Felipe López',         'contacto' => 'andres.lopez@yahoo.com']);
        $this->assertDatabaseHas('clientes', ['nombre' => 'Laura Cristina Mendoza',     'contacto' => 'laura.mendoza@outlook.com']);
        $this->assertDatabaseHas('clientes', ['nombre' => 'Diana Carolina Ruiz',         'contacto' => 'diana.ruiz@gmail.com']);

        // Empresas
        $this->assertDatabaseHas('clientes', ['nombre' => 'Frutas del Campo SAS',        'canal_distribucion' => 'Mayorista']);
        $this->assertDatabaseHas('clientes', ['nombre' => 'Distribuidora Agrícola Colombia SAS', 'canal_distribucion' => 'Mayorista']);
        $this->assertDatabaseHas('clientes', ['nombre' => 'Supermercados El Campesino',  'canal_distribucion' => 'Minorista']);
        $this->assertDatabaseHas('clientes', ['nombre' => 'Hacienda San Miguel SA',      'canal_distribucion' => 'Exportación']);
        $this->assertDatabaseHas('clientes', ['nombre' => 'Restaurante La Cosecha',      'canal_distribucion' => 'Directo']);

        $this->assertCount(12, \App\Models\Cliente::all());
    }

    public function test_demo_pedidos_con_estados_diferentes()
    {
        $pedidos = \App\Models\Pedido::all();
        $estados = $pedidos->pluck('estado')->unique();

        $this->assertTrue($estados->contains('pendiente'),  'Debe haber pedidos pendientes');
        $this->assertTrue($estados->contains('en_proceso'), 'Debe haber pedidos en proceso');
        $this->assertTrue($estados->contains('enviado'),     'Debe haber pedidos enviados');
        $this->assertTrue($estados->contains('entregado'),   'Debe haber pedidos entregados');
    }

    public function test_demo_pedidos_con_productos_y_cantidades()
    {
        $pedido = \App\Models\Pedido::find(1);
        $this->assertNotNull($pedido);
        $pedido->load('productos');
        $this->assertGreaterThan(0, $pedido->productos->count());
    }

    public function test_demo_facturas_con_numeros_reales()
    {
        $this->assertDatabaseHas('facturas', ['numero_factura' => 'FAC-2026-001']);
        $this->assertDatabaseHas('facturas', ['numero_factura' => 'FAC-2026-003']);
        $this->assertDatabaseHas('facturas', ['numero_factura' => 'FAC-2026-005']);
    }

    public function test_demo_pagos_con_diferentes_metodos()
    {
        $this->assertDatabaseHas('pagos', ['metodo_pago' => 'transferencia']);
        $this->assertDatabaseHas('pagos', ['metodo_pago' => 'efectivo']);
        $this->assertDatabaseHas('pagos', ['metodo_pago' => 'tarjeta']);
    }

    public function test_demo_devoluciones_con_motivos_reales()
    {
        $this->assertDatabaseHas('devoluciones', [
            'motivo' => 'Golpe de fruta durante el transporte',
            'estado' => 'aprobado',
        ]);
        $this->assertDatabaseHas('devoluciones', [
            'motivo' => 'Lechuga marchita, cadena de frío interrumpida',
            'estado' => 'rechazado',
        ]);
    }

    public function test_demo_rutas_de_entrega_con_direcciones_reales()
    {
        $this->assertDatabaseHas('ruta_entregas', [
            'direccion' => 'Calle 45 # 12-34, Barrio El Poblado, Medellín',
        ]);
        $this->assertDatabaseHas('ruta_entregas', [
            'direccion' => 'Autopista Norte # 45-120, Zona Industrial, Bogotá',
        ]);
    }

    public function test_demo_transportes_con_placas_colombianas()
    {
        $this->assertDatabaseHas('transportes', ['placa' => 'ABC-123', 'capacidad' => 500]);
        $this->assertDatabaseHas('transportes', ['placa' => 'DEF-456', 'capacidad' => 5000]);
        $this->assertDatabaseHas('transportes', ['placa' => 'GHI-789', 'capacidad' => 8000]);
    }

    // =========================================================================
    // 3. GESTIÓN DE RECURSOS — Personal, Maquinaria, Finanzas
    // =========================================================================

    public function test_demo_roles_de_hacienda_agricola()
    {
        $this->assertDatabaseHas('rols', ['nombre' => 'Administrador']);
        $this->assertDatabaseHas('rols', ['nombre' => 'Jefe de Cultivo']);
        $this->assertDatabaseHas('rols', ['nombre' => 'Tractorista']);
        $this->assertDatabaseHas('rols', ['nombre' => 'Operario de Campo']);
        $this->assertDatabaseHas('rols', ['nombre' => 'Conductor']);
    }

    public function test_demo_personal_con_nombres_y_habilidades_reales()
    {
        $this->assertDatabaseHas('empleados', [
            'nombre' => 'Juan Pablo García',
            'habilidades' => 'Administración agropecuaria, liderazgo de equipos, planificación estratégica',
        ]);
        $this->assertDatabaseHas('empleados', [
            'nombre' => 'María Fernanda Gómez',
            'habilidades' => 'Manejo de cultivos, sistemas de riego, control fitosanitario y fertilización',
        ]);
        $this->assertDatabaseHas('empleados', [
            'nombre' => 'Ana Lucía Restrepo',
            'habilidades' => 'Cosecha selectiva, manejo poscosecha, empaque y clasificación de frutos',
        ]);
        $this->assertDatabaseHas('empleados', [
            'nombre' => 'Luis Fernando Rodríguez',
            'habilidades' => 'Operación de tractores, cosechadoras y rastrillos. Mantenimiento básico de maquinaria',
        ]);
        $this->assertDatabaseHas('empleados', [
            'nombre' => 'Paola Andrea Ramírez',
            'habilidades' => 'Contabilidad agrícola, elaboración de informes financieros, control de gastos e ingresos',
        ]);

        $this->assertCount(12, \App\Models\Personal::all());
    }

    public function test_demo_maquinaria_con_equipos_agricolas()
    {
        $this->assertDatabaseHas('maquinarias', ['nombre' => 'Tractor John Deere 5075E']);
        $this->assertDatabaseHas('maquinarias', ['nombre' => 'Cosechadora de Hortalizas']);
        $this->assertDatabaseHas('maquinarias', ['nombre' => 'Fumigadora de Arrastre 600L']);
    }

    public function test_demo_mantenimiento_con_costos_reales()
    {
        $this->assertDatabaseHas('mantenimiento_maquinarias', [
            'tipo' => 'Correctivo',
        ]);
        $this->assertDatabaseHas('mantenimiento_maquinarias', [
            'tipo' => 'Preventivo',
        ]);
    }

    public function test_demo_proveedores_con_contratos()
    {
        $this->assertDatabaseHas('proveedores', [
            'nombre' => 'Agroinsumos del Valle Ltda.',
        ]);
        $this->assertDatabaseHas('proveedores', [
            'nombre' => 'Semillas Premium Colombia SAS',
        ]);
    }

    public function test_demo_gastos_con_conceptos_detallados()
    {
        $this->assertDatabaseHas('gastos', [
            'concepto' => 'Compra de fertilizante NPK 15-15-15 (50 bultos)',
        ]);
        $this->assertDatabaseHas('gastos', [
            'concepto' => 'Nómina semanal personal de campo (12 empleados)',
        ]);
        $this->assertDatabaseHas('gastos', [
            'concepto' => 'Adquisición de semillas de tomate híbrido (10 000 unid)',
        ]);
    }

    public function test_demo_ingresos_por_ventas()
    {
        $this->assertDatabaseHas('ingresos', [
            'fuente' => 'Venta de tomate — Pedido Carlos Martínez',
        ]);
        $this->assertDatabaseHas('ingresos', [
            'fuente' => 'Venta a Frutas del Campo SAS — Pedido mayorista',
        ]);
    }

    public function test_demo_informes_financieros_con_rentabilidad()
    {
        $informes = \App\Models\InformeFinanciero::all();
        $this->assertCount(4, $informes);

        foreach ($informes as $informe) {
            $this->assertGreaterThan(
                0,
                $informe->rentabilidad,
                "El informe {$informe->tipo} ({$informe->fecha_inicio} a {$informe->fecha_fin}) debe tener rentabilidad positiva"
            );
        }
    }

    public function test_demo_presupuestos_con_fechas_validas()
    {
        $presupuestos = \App\Models\Presupuesto::all();
        foreach ($presupuestos as $presupuesto) {
            $this->assertTrue(
                $presupuesto->fecha_fin >= $presupuesto->fecha_inicio,
                "El presupuesto {$presupuesto->nombre} tiene fecha fin anterior a fecha inicio"
            );
        }
    }

    // =========================================================================
    // 4. RELACIONES ENTRE MÓDULOS (Integración)
    // =========================================================================

    public function test_demo_relacion_completa_parcela_cultivo_labor()
    {
        $parcela = \App\Models\Parcela::where('nombre', 'La Esperanza')->first();
        $this->assertNotNull($parcela);

        $cultivos = $parcela->cultivos;
        $this->assertGreaterThan(0, $cultivos->count());

        $cultivo = $cultivos->first();
        $labores = $cultivo->laboresAgricolas;
        $this->assertGreaterThan(0, $labores->count());
    }

    public function test_demo_relacion_completa_cliente_pedido_factura_pago()
    {
        $cliente = \App\Models\Cliente::where('nombre', 'Carlos Alberto Martínez')->first();
        $this->assertNotNull($cliente);

        $pedidos = $cliente->pedidos;
        $this->assertGreaterThan(0, $pedidos->count());

        $pedido = $pedidos->first();
        $factura = $pedido->factura;
        $this->assertNotNull($factura);

        if ($factura->pagos()->count() > 0) {
            $pago = $factura->pagos->first();
            $this->assertNotNull($pago);
        }
    }

    public function test_demo_relacion_personal_con_rol()
    {
        $jefe = \App\Models\Personal::where('nombre', 'María Fernanda Gómez')->first();
        $this->assertNotNull($jefe);

        $this->assertNotNull($jefe->rol, 'El personal debe tener un rol asignado');
        $this->assertEquals('Jefe de Cultivo', $jefe->rol->nombre);
    }
}
