<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Factura;
use App\Models\Pago;
use App\Models\Devolucion;
use App\Models\RutaEntrega;
use App\Models\Transporte;
use App\Models\ProductoTerminado;
use App\Models\InventarioProductos;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VentaDistribucionModuleTest extends TestCase
{
    use RefreshDatabase;

    // ========================================================================
    // DEVOLUCIÓN
    // ========================================================================

    public function test_puede_ver_listado_de_devoluciones()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $producto = ProductoTerminado::factory()->create();
        Devolucion::create([
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 10.00,
            'motivo' => 'Producto dañado',
            'estado' => 'pendiente',
        ]);

        $response = $this->get(route('devoluciones.index'));

        $response->assertStatus(200);
        $response->assertViewHas('devoluciones');
    }

    public function test_puede_crear_devolucion()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $producto = ProductoTerminado::factory()->create();

        $response = $this->post(route('devoluciones.store'), [
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 15.50,
            'motivo' => 'Producto en mal estado',
            'estado' => 'pendiente',
        ]);

        $response->assertRedirect(route('devoluciones.index'));
        $this->assertDatabaseHas('devoluciones', [
            'pedido_id' => $pedido->id,
            'cantidad' => 15.50,
            'motivo' => 'Producto en mal estado',
        ]);
    }

    public function test_puede_actualizar_devolucion()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $producto = ProductoTerminado::factory()->create();
        $devolucion = Devolucion::create([
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 10.00,
            'motivo' => 'Dañado',
            'estado' => 'pendiente',
        ]);

        $response = $this->put(route('devoluciones.update', $devolucion), [
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 10.00,
            'motivo' => 'Dañado - Aprobado',
            'estado' => 'aprobado',
        ]);

        $response->assertRedirect(route('devoluciones.index'));
        $this->assertEquals('aprobado', $devolucion->fresh()->estado);
    }

    public function test_puede_eliminar_devolucion()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $producto = ProductoTerminado::factory()->create();
        $devolucion = Devolucion::create([
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 5.00,
            'motivo' => 'Prueba',
            'estado' => 'pendiente',
        ]);

        $response = $this->delete(route('devoluciones.destroy', $devolucion));

        $response->assertRedirect(route('devoluciones.index'));
        $this->assertDatabaseMissing('devoluciones', ['id' => $devolucion->id]);
    }

    public function test_valida_campos_requeridos_devolucion()
    {
        $response = $this->post(route('devoluciones.store'), [
            'pedido_id' => '',
            'producto_id' => '',
            'cantidad' => '',
            'motivo' => '',
            'estado' => '',
        ]);

        $response->assertSessionHasErrors(['pedido_id', 'producto_id', 'cantidad', 'motivo', 'estado']);
    }

    // ========================================================================
    // RUTA DE ENTREGA
    // ========================================================================

    public function test_puede_ver_listado_de_rutas_entrega()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        RutaEntrega::create([
            'pedido_id' => $pedido->id,
            'secuencia' => 1,
            'direccion' => 'Finca El Porvenir, Vereda La Esperanza',
            'estado' => 'pendiente',
        ]);

        $response = $this->get(route('rutas-entrega.index'));

        $response->assertStatus(200);
        $response->assertViewHas('rutasEntrega');
    }

    public function test_puede_crear_ruta_entrega()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();

        $response = $this->post(route('rutas-entrega.store'), [
            'pedido_id' => $pedido->id,
            'secuencia' => 1,
            'direccion' => 'Km 5 Vía al Llano, Bodega Central',
            'estado' => 'pendiente',
        ]);

        $response->assertRedirect(route('rutas-entrega.index'));
        $this->assertDatabaseHas('ruta_entregas', [
            'pedido_id' => $pedido->id,
            'direccion' => 'Km 5 Vía al Llano, Bodega Central',
        ]);
    }

    public function test_puede_actualizar_ruta_entrega()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $ruta = RutaEntrega::create([
            'pedido_id' => $pedido->id,
            'secuencia' => 1,
            'direccion' => 'Dirección Original',
            'estado' => 'pendiente',
        ]);

        $response = $this->put(route('rutas-entrega.update', $ruta), [
            'pedido_id' => $pedido->id,
            'secuencia' => 2,
            'direccion' => 'Dirección Actualizada',
            'estado' => 'en_proceso',
        ]);

        $response->assertRedirect(route('rutas-entrega.index'));
        $this->assertEquals('Dirección Actualizada', $ruta->fresh()->direccion);
        $this->assertEquals(2, $ruta->fresh()->secuencia);
    }

    public function test_puede_eliminar_ruta_entrega()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $ruta = RutaEntrega::create([
            'pedido_id' => $pedido->id,
            'secuencia' => 1,
            'direccion' => 'Dir',
            'estado' => 'pendiente',
        ]);

        $response = $this->delete(route('rutas-entrega.destroy', $ruta));

        $response->assertRedirect(route('rutas-entrega.index'));
        $this->assertDatabaseMissing('ruta_entregas', ['id' => $ruta->id]);
    }

    public function test_valida_campos_requeridos_ruta_entrega()
    {
        $response = $this->post(route('rutas-entrega.store'), [
            'pedido_id' => '',
            'secuencia' => '',
            'direccion' => '',
            'estado' => '',
        ]);

        $response->assertSessionHasErrors(['pedido_id', 'secuencia', 'direccion', 'estado']);
    }

    // ========================================================================
    // TRANSPORTE
    // ========================================================================

    public function test_puede_ver_listado_de_transportes()
    {
        Transporte::factory()->count(3)->create();

        $response = $this->get(route('transportes.index'));

        $response->assertStatus(200);
        $response->assertViewHas('transportes');
    }

    public function test_puede_crear_transporte()
    {
        $response = $this->post(route('transportes.store'), [
            'tipo' => 'Turbo',
            'placa' => 'XYZ-789',
            'capacidad' => 8000,
        ]);

        $response->assertRedirect(route('transportes.index'));
        $this->assertDatabaseHas('transportes', [
            'placa' => 'XYZ-789',
            'capacidad' => 8000,
        ]);
    }

    public function test_puede_actualizar_transporte()
    {
        $transporte = Transporte::factory()->create([
            'tipo' => 'Camión',
        ]);

        $response = $this->put(route('transportes.update', $transporte), [
            'tipo' => 'Camioneta',
            'placa' => $transporte->placa,
            'capacidad' => $transporte->capacidad,
        ]);

        $response->assertRedirect(route('transportes.index'));
        $this->assertEquals('Camioneta', $transporte->fresh()->tipo);
    }

    public function test_no_puede_eliminar_transporte_con_pedidos_asociados()
    {
        $transporte = Transporte::factory()->create();
        $cliente = Cliente::factory()->create();
        Pedido::factory()->for($cliente)->for($transporte)->create();

        $response = $this->delete(route('transportes.destroy', $transporte));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('transportes', ['id' => $transporte->id]);
    }

    public function test_puede_eliminar_transporte_sin_pedidos()
    {
        $transporte = Transporte::factory()->create();

        $response = $this->delete(route('transportes.destroy', $transporte));

        $response->assertRedirect(route('transportes.index'));
        $this->assertDatabaseMissing('transportes', ['id' => $transporte->id]);
    }

    public function test_valida_placa_unica_en_transporte()
    {
        Transporte::factory()->create(['placa' => 'ABC-123']);

        $response = $this->post(route('transportes.store'), [
            'tipo' => 'Camión',
            'placa' => 'ABC-123',
            'capacidad' => 5000,
        ]);

        $response->assertSessionHasErrors('placa');
    }

    // ========================================================================
    // PAGO (con lógica de negocio: validación de monto)
    // ========================================================================

    public function test_puede_ver_listado_de_pagos()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $factura = Factura::factory()->for($pedido)->create([
            'total' => 1190000.00,
        ]);
        Pago::factory()->count(2)->for($factura)->create();

        $response = $this->get(route('pagos.index'));

        $response->assertStatus(200);
        $response->assertViewHas('pagos');
    }

    public function test_puede_crear_pago()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $factura = Factura::factory()->for($pedido)->create([
            'total' => 1000000.00,
            'estado_pago' => 'pendiente',
        ]);

        $response = $this->post(route('pagos.store'), [
            'factura_id' => $factura->id,
            'monto' => 500000.00,
            'fecha' => '2026-05-15',
            'metodo_pago' => 'transferencia',
        ]);

        $response->assertRedirect(route('pagos.index'));
        $this->assertDatabaseHas('pagos', [
            'factura_id' => $factura->id,
            'monto' => 500000.00,
        ]);
    }

    public function test_no_puede_exceder_saldo_pendiente_de_factura()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $factura = Factura::factory()->for($pedido)->create([
            'total' => 100000.00,
            'estado_pago' => 'pendiente',
        ]);

        // Intentar pagar más del total
        $response = $this->post(route('pagos.store'), [
            'factura_id' => $factura->id,
            'monto' => 200000.00,
            'fecha' => '2026-05-15',
            'metodo_pago' => 'efectivo',
        ]);

        $response->assertSessionHasErrors('monto');
    }

    public function test_puede_actualizar_pago()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $factura = Factura::factory()->for($pedido)->create([
            'total' => 500000.00,
        ]);
        $pago = Pago::factory()->for($factura)->create([
            'monto' => 200000.00,
        ]);

        $response = $this->put(route('pagos.update', $pago), [
            'factura_id' => $factura->id,
            'monto' => 300000.00,
            'fecha' => $pago->fecha,
            'metodo_pago' => $pago->metodo_pago,
        ]);

        $response->assertRedirect(route('pagos.index'));
        $this->assertEquals(300000.00, $pago->fresh()->monto);
    }

    public function test_puede_eliminar_pago()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $factura = Factura::factory()->for($pedido)->create();
        $pago = Pago::factory()->for($factura)->create();

        $response = $this->delete(route('pagos.destroy', $pago));

        $response->assertRedirect(route('pagos.index'));
        $this->assertDatabaseMissing('pagos', ['id' => $pago->id]);
    }

    // ========================================================================
    // FACTURA (extendido - desde controlador HTTP)
    // ========================================================================

    public function test_puede_crear_factura_desde_controlador()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();

        $response = $this->post(route('facturas.store'), [
            'pedido_id' => $pedido->id,
            'numero_factura' => 'FAC-TEST-001',
            'subtotal' => 500000.00,
            'total' => 595000.00,
            'estado_pago' => 'pendiente',
        ]);

        $response->assertRedirect(route('facturas.index'));
        $this->assertDatabaseHas('facturas', [
            'numero_factura' => 'FAC-TEST-001',
            'total' => 595000.00,
        ]);
    }

    public function test_no_puede_crear_factura_con_pedido_ya_facturado()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        Factura::factory()->for($pedido)->create([
            'numero_factura' => 'FAC-001',
        ]);

        $response = $this->post(route('facturas.store'), [
            'pedido_id' => $pedido->id,
            'numero_factura' => 'FAC-002',
            'subtotal' => 100000.00,
            'total' => 119000.00,
            'estado_pago' => 'pendiente',
        ]);

        $response->assertSessionHasErrors('pedido_id');
    }

    public function test_no_puede_eliminar_factura_con_pagos_asociados()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $factura = Factura::factory()->for($pedido)->create();
        Pago::factory()->for($factura)->create();

        $response = $this->delete(route('facturas.destroy', $factura));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('facturas', ['id' => $factura->id]);
    }

    // ========================================================================
    // PRODUCTO (vista de listado con inventario)
    // ========================================================================

    public function test_puede_ver_pagina_de_productos()
    {
        ProductoTerminado::factory()->count(3)->create();

        $response = $this->get(route('productos.index'));

        $response->assertStatus(200);
        $response->assertViewHas('productos');
    }

    public function test_producto_muestra_inventario_en_listado()
    {
        $producto = ProductoTerminado::factory()->create(['nombre' => 'Tomate']);
        InventarioProductos::factory()->for($producto, 'producto')->create([
            'cantidad_disponible' => 500,
        ]);

        $response = $this->get(route('productos.index'));

        $response->assertStatus(200);
    }

    // ========================================================================
    // PEDIDO (extendido - con productos y cantidades)
    // ========================================================================

    public function test_pedido_puede_crearse_con_productos_y_cantidades()
    {
        $cliente = Cliente::factory()->create();
        $producto = ProductoTerminado::factory()->create();
        InventarioProductos::factory()->for($producto, 'producto')->create([
            'cantidad_disponible' => 100,
        ]);

        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 25],
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $pedido = Pedido::first();
        $this->assertDatabaseHas('pedido_producto', [
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 25,
        ]);
    }
}
