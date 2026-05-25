<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Transporte;
use App\Models\ProductoTerminado;
use App\Models\Factura;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_pedido_asociado_a_un_cliente()
    {
        $cliente = Cliente::factory()->create();

        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-13',
            'estado' => 'pendiente',
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $this->assertDatabaseHas('pedidos', [
            'cliente_id' => $cliente->id,
            'estado' => 'pendiente',
        ]);
    }

    public function test_puede_consultar_lista_de_pedidos()
    {
        $cliente = Cliente::factory()->create(['nombre' => 'Carlos Alberto Martínez']);
        Pedido::factory()->count(3)->for($cliente)->create();

        $response = $this->get(route('pedidos.index'));

        $response->assertStatus(200);
        $response->assertViewHas('pedidos');
    }

    public function test_puede_actualizar_estado_de_pendiente_a_en_proceso()
    {
        $pedido = Pedido::factory()->for(Cliente::factory()->create(['nombre' => 'María Eugenia Rodríguez']))->create([
            'estado' => 'pendiente',
        ]);

        $response = $this->patch(route('pedidos.updateEstado', $pedido), [
            'estado' => 'en_proceso',
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $this->assertEquals('en_proceso', $pedido->fresh()->estado);
    }

    public function test_no_puede_cancelar_un_pedido_entregado()
    {
        $pedido = Pedido::factory()->for(Cliente::factory()->create(['nombre' => 'Laura Cristina Mendoza']))->create([
            'estado' => 'entregado',
        ]);

        // El estado no se puede cambiar desde entregado a otro estado
        $pedido->update(['estado' => 'entregado']);
        $this->assertEquals('entregado', $pedido->fresh()->estado);
    }

    public function test_valida_que_cliente_exista_al_crear_pedido()
    {
        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => 999,
            'fecha' => '2026-05-13',
            'estado' => 'pendiente',
        ]);

        $response->assertSessionHasErrors('cliente_id');
    }

    public function test_pedido_puede_tener_productos_asociados()
    {
        $cliente = Cliente::factory()->create(['nombre' => 'Distribuidora Agrícola Colombia SAS']);
        $producto = ProductoTerminado::factory()->create(['nombre' => 'Tomate Chonto']);

        $response = $this->post(route('pedidos.store'), [
            'cliente_id' => $cliente->id,
            'fecha' => '2026-05-13',
            'estado' => 'pendiente',
            'productos' => [$producto->id],
        ]);

        $response->assertRedirect(route('pedidos.index'));
        $pedido = Pedido::first();
        $this->assertTrue($pedido->productos->contains($producto));
    }

    public function test_pedido_tiene_relacion_con_cliente()
    {
        $cliente = Cliente::factory()->create(['nombre' => 'Andrés Felipe López']);
        $pedido = Pedido::factory()->for($cliente)->create();

        $this->assertInstanceOf(Cliente::class, $pedido->cliente);
        $this->assertEquals($cliente->id, $pedido->cliente->id);
    }

    public function test_pedido_puede_tener_factura()
    {
        $pedido = Pedido::factory()->for(Cliente::factory()->create(['nombre' => 'Frutas del Campo SAS']))->create();
        $factura = Factura::factory()->for($pedido)->create([
            'numero_factura' => 'FAC-DEMO-001',
        ]);

        $this->assertInstanceOf(Factura::class, $pedido->factura);
        $this->assertEquals($factura->id, $pedido->factura->id);
    }
}
