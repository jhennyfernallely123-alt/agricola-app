<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\ProductoTerminado;
use App\Models\InventarioProductos;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Crea un cliente y un producto con inventario para agilizar los tests.
     */
    private function crearClienteYProducto(int $stock = 100): array
    {
        $cliente = Cliente::factory()->create();
        $producto = ProductoTerminado::factory()->create();
        InventarioProductos::factory()->for($producto, 'producto')->create([
            'cantidad_disponible' => $stock,
        ]);
        return [$cliente, $producto];
    }

    // ========================================================================
    // STORE - Creación de pedidos
    // ========================================================================

    public function test_puede_crear_pedido_con_stock_suficiente()
    {
        [$cliente, $producto] = $this->crearClienteYProducto(stock: 100);

        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 50],
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $pedido = Pedido::first();
        $this->assertDatabaseHas('pedido_producto', [
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 50,
        ]);
    }

    public function test_no_puede_crear_pedido_con_stock_insuficiente()
    {
        [$cliente, $producto] = $this->crearClienteYProducto(stock: 10);

        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 20],
        ]);

        $response->assertSessionHasErrors('productos');
        $this->assertDatabaseCount('pedido_producto', 0);
    }

    public function test_no_puede_crear_pedido_con_producto_sin_stock()
    {
        [$cliente, $producto] = $this->crearClienteYProducto(stock: 0);

        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 1],
        ]);

        $response->assertSessionHasErrors('productos');
        $this->assertDatabaseCount('pedido_producto', 0);
    }

    public function test_puede_crear_pedido_con_cantidad_cero_en_producto()
    {
        [$cliente, $producto] = $this->crearClienteYProducto(stock: 50);

        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 0],
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $pedido = Pedido::first();
        $this->assertDatabaseHas('pedido_producto', [
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 0,
        ]);
    }

    public function test_puede_crear_pedido_exactamente_con_stock_disponible()
    {
        [$cliente, $producto] = $this->crearClienteYProducto(stock: 75);

        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 75],
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $pedido = Pedido::first();
        $this->assertDatabaseHas('pedido_producto', [
            'pedido_id' => $pedido->id,
            'cantidad' => 75,
        ]);
    }

    public function test_pedido_con_varios_productos_validacion_stock_individual()
    {
        $cliente = Cliente::factory()->create();
        $producto1 = ProductoTerminado::factory()->create(['nombre' => 'Tomate']);
        $producto2 = ProductoTerminado::factory()->create(['nombre' => 'Yuca']);
        InventarioProductos::factory()->for($producto1, 'producto')->create(['cantidad_disponible' => 100]);
        InventarioProductos::factory()->for($producto2, 'producto')->create(['cantidad_disponible' => 0]);

        // Yuca con 0 stock: debe fallar porque cantidad 10 > 0
        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto1->id, $producto2->id],
            'cantidades' => [
                $producto1->id => 50,
                $producto2->id => 10, // Yuca sin stock!
            ],
        ]);

        $response->assertSessionHasErrors('productos');
        $this->assertDatabaseCount('pedido_producto', 0);
    }

    // ========================================================================
    // UPDATE - Actualización de pedidos existentes
    // ========================================================================

    public function test_puede_actualizar_pedido_aumentando_cantidad_si_hay_stock()
    {
        [$cliente, $producto] = $this->crearClienteYProducto(stock: 100);
        $pedido = Pedido::factory()->for($cliente)->create();
        $pedido->productos()->attach([$producto->id => ['cantidad' => 20]]);

        // Aumentar de 20 a 30 (aumento de 10, stock es 100)
        $response = $this->put(route('pedidos.update', $pedido), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 30],
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $this->assertDatabaseHas('pedido_producto', [
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 30,
        ]);
    }

    public function test_no_puede_actualizar_pedido_si_aumento_excede_stock_disponible()
    {
        [$cliente, $producto] = $this->crearClienteYProducto(stock: 10);
        $pedido = Pedido::factory()->for($cliente)->create();
        $pedido->productos()->attach([$producto->id => ['cantidad' => 20]]);

        // Ya tiene 20 en el pedido, stock restante = inventario(10) + original(20) = 30
        // Pedir 35 > 30 → debe fallar
        $response = $this->put(route('pedidos.update', $pedido), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 35],
        ]);

        $response->assertSessionHasErrors('productos');
        // Verificar que la cantidad en la BD sigue siendo 20
        $this->assertDatabaseHas('pedido_producto', [
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 20,
        ]);
    }

    public function test_puede_actualizar_pedido_reduciendo_cantidad_sin_validar_stock()
    {
        [$cliente, $producto] = $this->crearClienteYProducto(stock: 0);
        $pedido = Pedido::factory()->for($cliente)->create();
        $pedido->productos()->attach([$producto->id => ['cantidad' => 50]]);

        // Reducir de 50 a 10 (no aumenta, no se valida stock)
        $response = $this->put(route('pedidos.update', $pedido), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 10],
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $this->assertDatabaseHas('pedido_producto', [
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 10,
        ]);
    }

    public function test_puede_actualizar_pedido_manteniendo_la_misma_cantidad()
    {
        [$cliente, $producto] = $this->crearClienteYProducto(stock: 5);
        $pedido = Pedido::factory()->for($cliente)->create();
        $pedido->productos()->attach([$producto->id => ['cantidad' => 30]]);

        // Misma cantidad 30, stock 5, pero original es 30, y validator solo checkea si cantidad > original
        // 30 > 30 es false, así que no valida stock
        $response = $this->put(route('pedidos.update', $pedido), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 30],
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $this->assertDatabaseHas('pedido_producto', [
            'pedido_id' => $pedido->id,
            'cantidad' => 30,
        ]);
    }

    public function test_puede_actualizar_pedido_con_aumento_dentro_de_stock_restante()
    {
        // Stock = 10, Original = 15, quiere 20
        // Stock restante = 10 + 15 = 25
        // 20 <= 25 → debe funcionar
        [$cliente, $producto] = $this->crearClienteYProducto(stock: 10);
        $pedido = Pedido::factory()->for($cliente)->create();
        $pedido->productos()->attach([$producto->id => ['cantidad' => 15]]);

        $response = $this->put(route('pedidos.update', $pedido), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 20],
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $this->assertDatabaseHas('pedido_producto', [
            'pedido_id' => $pedido->id,
            'cantidad' => 20,
        ]);
    }

    // ========================================================================
    // CASOS ESPECIALES
    // ========================================================================

    public function test_pedido_sin_productos_no_dispara_validacion_stock()
    {
        $cliente = Cliente::factory()->create();

        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $this->assertDatabaseHas('pedidos', ['cliente_id' => $cliente->id]);
    }

    public function test_pedido_puede_actualizarse_sin_productos()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();

        $response = $this->put(route('pedidos.update', $pedido), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'en_proceso',
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $this->assertEquals('en_proceso', $pedido->fresh()->estado);
    }

    public function test_producto_sin_registro_de_inventario_se_permite()
    {
        $cliente = Cliente::factory()->create();
        $producto = ProductoTerminado::factory()->create();
        // No crear InventarioProductos - sin registro de inventario

        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-20',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
            'cantidades' => [$producto->id => 100],
        ]);

        // Como no hay inventario, $inventario es null, la condición del if es false
        $response->assertRedirect(route('pedidos.index'));
        $pedido = Pedido::first();
        $this->assertDatabaseHas('pedido_producto', [
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 100,
        ]);
    }
}
