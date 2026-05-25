<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\ProductoTerminado;
use App\Models\InventarioProductos;
use App\Models\Transporte;
use App\Models\Factura;
use App\Models\Pago;
use App\Models\Devolucion;
use App\Models\RutaEntrega;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VentaDistribucionSeeder extends Seeder
{
    /**
     * Seed del módulo Venta y Distribución con datos realistas colombianos.
     */
    public function run(): void
    {
        // ====================================================================
        // 1. CLIENTES — Personas y empresas colombianas
        // ====================================================================
        $clientes = [
            // Personas naturales
            ['nombre' => 'Carlos Alberto Martínez',     'contacto' => 'carlos.martinez@gmail.com',       'canal_distribucion' => 'Directo'],
            ['nombre' => 'María Eugenia Rodríguez',     'contacto' => 'maria.rodriguez@hotmail.com',     'canal_distribucion' => 'Directo'],
            ['nombre' => 'Andrés Felipe López',         'contacto' => 'andres.lopez@yahoo.com',          'canal_distribucion' => 'Mayorista'],
            ['nombre' => 'Laura Cristina Mendoza',     'contacto' => 'laura.mendoza@outlook.com',       'canal_distribucion' => 'Minorista'],
            ['nombre' => 'Juan Pablo García',           'contacto' => 'juan.garcia@email.com',           'canal_distribucion' => 'Directo'],
            ['nombre' => 'Diana Carolina Ruiz',         'contacto' => 'diana.ruiz@gmail.com',            'canal_distribucion' => 'Exportación'],
            // Empresas
            ['nombre' => 'Frutas del Campo SAS',        'contacto' => 'ventas@frutascampo.com.co',       'canal_distribucion' => 'Mayorista'],
            ['nombre' => 'Distribuidora Agrícola Colombia SAS', 'contacto' => 'pedidos@distriagri.com.co', 'canal_distribucion' => 'Mayorista'],
            ['nombre' => 'Supermercados El Campesino',  'contacto' => 'compras@elcampesino.com.co',      'canal_distribucion' => 'Minorista'],
            ['nombre' => 'Hacienda San Miguel SA',      'contacto' => 'administracion@haciedasamiguel.com','canal_distribucion' => 'Exportación'],
            ['nombre' => 'Restaurante La Cosecha',      'contacto' => 'chef@lacosecha.com',              'canal_distribucion' => 'Directo'],
            ['nombre' => 'Plaza de Mercado Central',    'contacto' => 'central@mercadomayorista.co',     'canal_distribucion' => 'Minorista'],
        ];

        foreach ($clientes as $data) {
            Cliente::firstOrCreate(['nombre' => $data['nombre']], $data);
        }

        $this->command->info('Clientes creados: ' . Cliente::count());

        // ====================================================================
        // 2. PRODUCTOS TERMINADOS (si no existen del seeder anterior)
        // ====================================================================
        $productos = [
            ['nombre' => 'Tomate Chonto',        'lote' => 'L-TC-001',  'calidad' => 'Premium',    'presentacion' => 'Bolsa 1kg'],
            ['nombre' => 'Tomate Cherry',        'lote' => 'L-TCH-001', 'calidad' => 'Premium',    'presentacion' => 'Cesta 500g'],
            ['nombre' => 'Lechuga Crespa',        'lote' => 'L-LC-001',  'calidad' => 'Premium',    'presentacion' => 'Unidad'],
            ['nombre' => 'Lechuga Romana',        'lote' => 'L-LR-001',  'calidad' => 'Primera',    'presentacion' => 'Unidad'],
            ['nombre' => 'Uva Isabella',          'lote' => 'L-UI-001',  'calidad' => 'Premium',    'presentacion' => 'Canasta 5kg'],
            ['nombre' => 'Mora de Castilla',      'lote' => 'L-MC-001',  'calidad' => 'Premium',    'presentacion' => 'Canasta 2kg'],
            ['nombre' => 'Fresa Albión',          'lote' => 'L-FA-001',  'calidad' => 'Premium',    'presentacion' => 'Bandeja 500g'],
            ['nombre' => 'Pimentón Rojo',         'lote' => 'L-PR-001',  'calidad' => 'Primera',    'presentacion' => 'Bolsa 500g'],
            ['nombre' => 'Pepino Coquito',        'lote' => 'L-PC-001',  'calidad' => 'Primera',    'presentacion' => 'Bolsa 1kg'],
            ['nombre' => 'Gulupa',                'lote' => 'L-GU-001',  'calidad' => 'Premium',    'presentacion' => 'Canasta 3kg'],
            ['nombre' => 'Granadilla',            'lote' => 'L-GR-001',  'calidad' => 'Premium',    'presentacion' => 'Malla 2kg'],
            ['nombre' => 'Cebolla de Ramas',      'lote' => 'L-CR-001',  'calidad' => 'Primera',    'presentacion' => 'Mazo'],
            ['nombre' => 'Cilantro',              'lote' => 'L-CI-001',  'calidad' => 'Premium',    'presentacion' => 'Manojo'],
            ['nombre' => 'Aguacate Hass',         'lote' => 'L-AH-001',  'calidad' => 'Premium',    'presentacion' => 'Unidad'],
        ];

        foreach ($productos as $data) {
            ProductoTerminado::firstOrCreate(
                ['nombre' => $data['nombre']],
                $data
            );
        }

        $this->command->info('Productos creados: ' . ProductoTerminado::count());

        // ====================================================================
        // 3. INVENTARIO DE PRODUCTOS
        // ====================================================================
        $inventarios = [
            ['nombre' => 'Tomate Chonto',    'cantidad_disponible' => 500,  'ubicacion' => 'Almacén A — Zona 2'],
            ['nombre' => 'Tomate Cherry',    'cantidad_disponible' => 200,  'ubicacion' => 'Almacén A — Estante 5'],
            ['nombre' => 'Lechuga Crespa',   'cantidad_disponible' => 300,  'ubicacion' => 'Cámara Fría 1 — 4°C'],
            ['nombre' => 'Lechuga Romana',   'cantidad_disponible' => 150,  'ubicacion' => 'Cámara Fría 1 — 4°C'],
            ['nombre' => 'Uva Isabella',     'cantidad_disponible' => 400,  'ubicacion' => 'Cámara Fría 2 — 2°C'],
            ['nombre' => 'Mora de Castilla', 'cantidad_disponible' => 180,  'ubicacion' => 'Cámara Fría 2 — 2°C'],
            ['nombre' => 'Fresa Albión',     'cantidad_disponible' => 250,  'ubicacion' => 'Cámara Fría 2 — 2°C'],
            ['nombre' => 'Pimentón Rojo',    'cantidad_disponible' => 350,  'ubicacion' => 'Almacén A — Zona 1'],
            ['nombre' => 'Pepino Coquito',   'cantidad_disponible' => 280,  'ubicacion' => 'Almacén B — Estante 3'],
            ['nombre' => 'Gulupa',           'cantidad_disponible' => 120,  'ubicacion' => 'Cámara Fría 1 — 8°C'],
            ['nombre' => 'Granadilla',       'cantidad_disponible' => 160,  'ubicacion' => 'Cámara Fría 1 — 8°C'],
            ['nombre' => 'Cebolla de Ramas', 'cantidad_disponible' => 200,  'ubicacion' => 'Almacén B — Estante 1'],
            ['nombre' => 'Cilantro',         'cantidad_disponible' => 90,   'ubicacion' => 'Almacén B — Estante 2'],
            ['nombre' => 'Aguacate Hass',    'cantidad_disponible' => 450,  'ubicacion' => 'Cámara Fría 2 — 6°C'],
        ];

        foreach ($inventarios as $data) {
            $producto = ProductoTerminado::where('nombre', $data['nombre'])->first();
            if ($producto) {
                InventarioProductos::firstOrCreate(
                    ['producto_id' => $producto->id],
                    [
                        'cantidad_disponible' => $data['cantidad_disponible'],
                        'ubicacion' => $data['ubicacion'],
                    ]
                );
            }
        }

        $this->command->info('Inventarios creados: ' . InventarioProductos::count());

        // ====================================================================
        // 4. TRANSPORTES — Vehículos de reparto colombianos
        // ====================================================================
        $transportes = [
            ['tipo' => 'Turbo',    'placa' => 'ABC-123', 'capacidad' => 500],
            ['tipo' => 'Camión',   'placa' => 'DEF-456', 'capacidad' => 5000],
            ['tipo' => 'Camión',   'placa' => 'GHI-789', 'capacidad' => 8000],
            ['tipo' => 'Camión',   'placa' => 'JKL-012', 'capacidad' => 10000],
            ['tipo' => 'Camión',   'placa' => 'MNO-345', 'capacidad' => 6000],
            ['tipo' => 'Camión',   'placa' => 'PQR-678', 'capacidad' => 4000],
            ['tipo' => 'Camión',   'placa' => 'STU-901', 'capacidad' => 7000],
        ];

        foreach ($transportes as $data) {
            Transporte::firstOrCreate(['placa' => $data['placa']], $data);
        }

        $this->command->info('Transportes creados: ' . Transporte::count());

        // ====================================================================
        // 5. PEDIDOS — Con diferentes estados y fechas
        // ====================================================================
        $pedidosData = [
            ['cliente_id' => 1, 'transporte_id' => 1, 'fecha' => '2026-04-01', 'estado' => 'entregado'],
            ['cliente_id' => 3, 'transporte_id' => 2, 'fecha' => '2026-04-10', 'estado' => 'entregado'],
            ['cliente_id' => 7, 'transporte_id' => 3, 'fecha' => '2026-04-20', 'estado' => 'entregado'],
            ['cliente_id' => 2, 'transporte_id' => null, 'fecha' => '2026-05-01', 'estado' => 'enviado'],
            ['cliente_id' => 9, 'transporte_id' => 4, 'fecha' => '2026-05-05', 'estado' => 'enviado'],
            ['cliente_id' => 4, 'transporte_id' => 5, 'fecha' => '2026-05-10', 'estado' => 'en_proceso'],
            ['cliente_id' => 8, 'transporte_id' => null, 'fecha' => '2026-05-12', 'estado' => 'en_proceso'],
            ['cliente_id' => 5, 'transporte_id' => null, 'fecha' => '2026-05-15', 'estado' => 'pendiente'],
            ['cliente_id' => 11, 'transporte_id' => 1, 'fecha' => '2026-05-16', 'estado' => 'pendiente'],
            ['cliente_id' => 10, 'transporte_id' => 6, 'fecha' => '2026-05-18', 'estado' => 'pendiente'],
            ['cliente_id' => 6, 'transporte_id' => null, 'fecha' => '2026-05-19', 'estado' => 'pendiente'],
        ];

        foreach ($pedidosData as $data) {
            try {
                Pedido::create($data);
            } catch (\Exception $e) {
                // Ignorar duplicados
            }
        }

        $this->command->info('Pedidos creados: ' . Pedido::count());

        // ====================================================================
        // 6. ASOCIAR PRODUCTOS A PEDIDOS (N:M con cantidades)
        // ====================================================================
        $pedidoProductos = [
            ['pedido_id' => 1, 'productos' => [1 => 50, 3 => 80, 5 => 30]],
            ['pedido_id' => 2, 'productos' => [6 => 40, 7 => 60, 10 => 20]],
            ['pedido_id' => 3, 'productos' => [1 => 100, 8 => 75, 9 => 60]],
            ['pedido_id' => 4, 'productos' => [3 => 40, 4 => 25]],
            ['pedido_id' => 5, 'productos' => [1 => 200, 5 => 50, 11 => 30]],
            ['pedido_id' => 6, 'productos' => [7 => 80, 6 => 50]],
            ['pedido_id' => 7, 'productos' => [2 => 30, 8 => 40]],
            ['pedido_id' => 8, 'productos' => [3 => 50]],
            ['pedido_id' => 9, 'productos' => [3 => 20, 13 => 40]],
            ['pedido_id' => 10, 'productos' => [14 => 100]],
            ['pedido_id' => 11, 'productos' => [6 => 30, 12 => 40]],
        ];

        foreach ($pedidoProductos as $item) {
            $pedido = Pedido::find($item['pedido_id']);
            if ($pedido) {
                $pivotData = [];
                foreach ($item['productos'] as $productoId => $cantidad) {
                    $pivotData[$productoId] = ['cantidad' => $cantidad];
                }
                try {
                    $pedido->productos()->syncWithoutDetaching($pivotData);
                } catch (\Exception $e) {
                    // Ignorar si ya existen
                }
            }
        }

        // ====================================================================
        // 7. FACTURAS — Para pedidos entregados o en proceso
        // ====================================================================
        $facturas = [
            ['pedido_id' => 1, 'numero_factura' => 'FAC-2026-001', 'subtotal' => 1250000.00, 'total' => 1487500.00, 'estado_pago' => 'pagado'],
            ['pedido_id' => 2, 'numero_factura' => 'FAC-2026-002', 'subtotal' => 980000.00,  'total' => 1166200.00, 'estado_pago' => 'pagado'],
            ['pedido_id' => 3, 'numero_factura' => 'FAC-2026-003', 'subtotal' => 2100000.00, 'total' => 2499000.00, 'estado_pago' => 'pagado'],
            ['pedido_id' => 4, 'numero_factura' => 'FAC-2026-004', 'subtotal' => 520000.00,  'total' => 618800.00,  'estado_pago' => 'pendiente'],
            ['pedido_id' => 5, 'numero_factura' => 'FAC-2026-005', 'subtotal' => 3100000.00, 'total' => 3689000.00, 'estado_pago' => 'parcial'],
            ['pedido_id' => 6, 'numero_factura' => 'FAC-2026-006', 'subtotal' => 890000.00,  'total' => 1059100.00, 'estado_pago' => 'pendiente'],
        ];

        foreach ($facturas as $data) {
            try {
                Factura::create($data);
            } catch (\Exception $e) {
                // Ignorar si el pedido ya tiene factura
            }
        }

        $this->command->info('Facturas creadas: ' . Factura::count());

        // ====================================================================
        // 8. PAGOS — Asociados a facturas
        // ====================================================================
        $pagos = [
            ['factura_id' => 1, 'monto' => 1487500.00, 'fecha' => '2026-04-05', 'metodo_pago' => 'transferencia'],
            ['factura_id' => 2, 'monto' => 600000.00,  'fecha' => '2026-04-15', 'metodo_pago' => 'efectivo'],
            ['factura_id' => 2, 'monto' => 566200.00,  'fecha' => '2026-04-20', 'metodo_pago' => 'transferencia'],
            ['factura_id' => 3, 'monto' => 2499000.00, 'fecha' => '2026-04-28', 'metodo_pago' => 'tarjeta'],
            ['factura_id' => 5, 'monto' => 1500000.00, 'fecha' => '2026-05-08', 'metodo_pago' => 'transferencia'],
        ];

        foreach ($pagos as $data) {
            try {
                Pago::create($data);
            } catch (\Exception $e) {
                // Ignorar duplicados
            }
        }

        $this->command->info('Pagos creados: ' . Pago::count());

        // ====================================================================
        // 9. DEVOLUCIONES
        // ====================================================================
        $devoluciones = [
            ['pedido_id' => 1, 'producto_id' => 1, 'cantidad' => 5.00,  'motivo' => 'Golpe de fruta durante el transporte',                        'estado' => 'aprobado'],
            ['pedido_id' => 2, 'producto_id' => 6, 'cantidad' => 3.00,  'motivo' => 'Mora con signos de fermentación',                            'estado' => 'aprobado'],
            ['pedido_id' => 3, 'producto_id' => 1, 'cantidad' => 10.00, 'motivo' => 'Tomate con daño por golpe, embalaje inadecuado',             'estado' => 'pendiente'],
            ['pedido_id' => 4, 'producto_id' => 4, 'cantidad' => 5.00,  'motivo' => 'Lechuga marchita, cadena de frío interrumpida',             'estado' => 'rechazado'],
        ];

        foreach ($devoluciones as $data) {
            try {
                Devolucion::create($data);
            } catch (\Exception $e) {
                // Ignorar duplicados
            }
        }

        $this->command->info('Devoluciones creadas: ' . Devolucion::count());

        // ====================================================================
        // 10. RUTAS DE ENTREGA
        // ====================================================================
        $rutas = [
            ['pedido_id' => 1, 'secuencia' => 1, 'direccion' => 'Calle 45 # 12-34, Barrio El Poblado, Medellín',             'estado' => 'entregado'],
            ['pedido_id' => 1, 'secuencia' => 2, 'direccion' => 'Carrera 20 # 15-60, Barrio Laureles, Medellín',             'estado' => 'entregado'],
            ['pedido_id' => 2, 'secuencia' => 1, 'direccion' => 'Vía al Llano Km 5, Bodega Central, Villavicencio',           'estado' => 'entregado'],
            ['pedido_id' => 3, 'secuencia' => 1, 'direccion' => 'Avenida 30 de Agosto # 25-10, Bodega 3, Pereira',           'estado' => 'entregado'],
            ['pedido_id' => 3, 'secuencia' => 2, 'direccion' => 'Calle 18 # 8-45, Centro Comercial, Armenia',                'estado' => 'entregado'],
            ['pedido_id' => 5, 'secuencia' => 1, 'direccion' => 'Autopista Norte # 45-120, Zona Industrial, Bogotá',         'estado' => 'en_proceso'],
            ['pedido_id' => 6, 'secuencia' => 1, 'direccion' => 'Finca El Porvenir, Vereda La Esperanza, Rionegro',          'estado' => 'pendiente'],
        ];

        foreach ($rutas as $data) {
            try {
                RutaEntrega::create($data);
            } catch (\Exception $e) {
                // Ignorar duplicados
            }
        }

        $this->command->info('Rutas de entrega creadas: ' . RutaEntrega::count());
    }
}
