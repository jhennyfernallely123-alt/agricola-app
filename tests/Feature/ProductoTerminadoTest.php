<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ProductoTerminado;
use App\Models\Parcela;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\InventarioProductos;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductoTerminadoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_producto_con_datos_basicos()
    {
        $producto = ProductoTerminado::create([
            'nombre' => 'Tomate',
            'variedad' => 'Cherry',
            'presentacion' => 'Caja 5kg',
            'lote' => 'L-001',
            'calidad' => 'Premium',
            'fecha_cosecha' => '2026-05-01',
        ]);

        $this->assertDatabaseHas('productos', [
            'nombre' => 'Tomate',
            'lote' => 'L-001',
        ]);
    }

    public function test_producto_puede_tener_inventario_asociado()
    {
        $producto = ProductoTerminado::factory()->create();
        $inventario = InventarioProductos::factory()->for($producto, 'producto')->create([
            'cantidad_disponible' => 100.00,
        ]);

        $this->assertInstanceOf(InventarioProductos::class, $producto->inventario);
        $this->assertEquals(100.00, $producto->inventario->cantidad_disponible);
    }

    public function test_producto_pertenece_a_una_parcela_origen()
    {
        $parcela = Parcela::factory()->create();
        $producto = ProductoTerminado::factory()->for($parcela, 'parcelaOrigen')->create();

        $this->assertInstanceOf(Parcela::class, $producto->parcelaOrigen);
        $this->assertEquals($parcela->id, $producto->parcelaOrigen->id);
    }

    public function test_producto_puede_estar_en_varios_pedidos()
    {
        $producto = ProductoTerminado::factory()->create();
        $pedido1 = Pedido::factory()->for(Cliente::factory())->create();
        $pedido2 = Pedido::factory()->for(Cliente::factory())->create();

        $pedido1->productos()->attach($producto->id);
        $pedido2->productos()->attach($producto->id);

        $this->assertCount(2, $producto->pedidos);
    }

    public function test_producto_puede_tener_devoluciones()
    {
        $producto = ProductoTerminado::factory()->create();
        $pedido = Pedido::factory()->for(Cliente::factory())->create();

        $devolucion = $producto->devoluciones()->create([
            'pedido_id' => $pedido->id,
            'cantidad' => 10.00,
            'motivo' => 'Producto dañado',
        ]);

        $this->assertCount(1, $producto->devoluciones);
        $this->assertEquals('Producto dañado', $producto->devoluciones->first()->motivo);
    }
}
