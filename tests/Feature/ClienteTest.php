<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_cliente_con_nombre_contacto_y_canal()
    {
        $response = $this->post(route('clientes.store'), [
            'nombre' => 'Juan Pérez',
            'contacto' => 'juan@email.com',
            'canal_distribucion' => 'directo',
        ]);

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', [
            'nombre' => 'Juan Pérez',
            'contacto' => 'juan@email.com',
            'canal_distribucion' => 'directo',
        ]);
    }

    public function test_puede_consultar_todos_los_clientes()
    {
        Cliente::factory()->count(3)->create();

        $response = $this->get(route('clientes.index'));

        $response->assertStatus(200);
        $response->assertViewHas('clientes');
    }

    public function test_puede_actualizar_datos_de_un_cliente()
    {
        $cliente = Cliente::factory()->create([
            'nombre' => 'Nombre Original',
        ]);

        $response = $this->put(route('clientes.update', $cliente), [
            'nombre' => 'Nombre Actualizado',
            'contacto' => $cliente->contacto,
            'canal_distribucion' => $cliente->canal_distribucion,
        ]);

        $response->assertRedirect(route('clientes.index'));
        $this->assertEquals('Nombre Actualizado', $cliente->fresh()->nombre);
    }

    public function test_no_puede_eliminar_cliente_con_pedidos_asociados()
    {
        $cliente = Cliente::factory()->create();
        Pedido::factory()->for($cliente)->create();

        $response = $this->delete(route('clientes.destroy', $cliente));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('clientes', ['id' => $cliente->id]);
    }

    public function test_valida_que_nombre_es_obligatorio()
    {
        $response = $this->post(route('clientes.store'), [
            'nombre' => '',
        ]);

        $response->assertSessionHasErrors('nombre');
    }

    public function test_cliente_tiene_relacion_con_pedidos()
    {
        $cliente = Cliente::factory()->create();
        $pedido1 = Pedido::factory()->for($cliente)->create();
        $pedido2 = Pedido::factory()->for($cliente)->create();

        $this->assertCount(2, $cliente->pedidos);
        $this->assertTrue($cliente->pedidos->contains($pedido1));
        $this->assertTrue($cliente->pedidos->contains($pedido2));
    }
}
