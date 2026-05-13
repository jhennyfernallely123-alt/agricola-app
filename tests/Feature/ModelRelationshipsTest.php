<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Factura;
use App\Models\Pago;
use App\Models\ProductoTerminado;
use App\Models\InventarioProductos;
use App\Models\Transporte;
use App\Models\Parcela;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_cliente_tiene_muchos_pedidos()
    {
        $cliente = Cliente::factory()->create();
        Pedido::factory()->count(3)->for($cliente)->create();

        $this->assertCount(3, $cliente->pedidos);
        $this->assertInstanceOf(Pedido::class, $cliente->pedidos->first());
    }

    public function test_pedido_pertenece_a_cliente()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();

        $this->assertInstanceOf(Cliente::class, $pedido->cliente);
        $this->assertEquals($cliente->id, $pedido->cliente->id);
    }

    public function test_pedido_tiene_una_factura()
    {
        $pedido = Pedido::factory()->for(Cliente::factory())->create();
        $factura = Factura::factory()->for($pedido)->create();

        $this->assertInstanceOf(Factura::class, $pedido->factura);
        $this->assertEquals($factura->id, $pedido->factura->id);
    }

    public function test_factura_tiene_muchos_pagos()
    {
        $pedido = Pedido::factory()->for(Cliente::factory())->create();
        $factura = Factura::factory()->for($pedido)->create();
        Pago::factory()->count(2)->for($factura)->create();

        $this->assertCount(2, $factura->pagos);
    }

    public function test_pedido_pertenece_a_transporte()
    {
        $transporte = Transporte::factory()->create();
        $pedido = Pedido::factory()->for(Cliente::factory())->for($transporte)->create();

        $this->assertInstanceOf(Transporte::class, $pedido->transporte);
    }

    public function test_producto_pertenece_a_parcela()
    {
        $parcela = Parcela::factory()->create();
        $producto = ProductoTerminado::factory()->for($parcela, 'parcelaOrigen')->create();

        $this->assertInstanceOf(Parcela::class, $producto->parcelaOrigen);
    }

    public function test_producto_tiene_un_inventario()
    {
        $producto = ProductoTerminado::factory()->create();
        InventarioProductos::factory()->for($producto, 'producto')->create();

        $this->assertInstanceOf(InventarioProductos::class, $producto->inventario);
    }
}
