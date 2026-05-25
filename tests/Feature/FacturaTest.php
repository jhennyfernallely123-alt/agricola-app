<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Factura;
use App\Models\Pedido;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacturaTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_una_factura_asociada_a_un_pedido()
    {
        $cliente = Cliente::factory()->create(['nombre' => 'Diana Carolina Ruiz']);
        $pedido = Pedido::factory()->for($cliente)->create();

        $factura = Factura::create([
            'pedido_id' => $pedido->id,
            'numero_factura' => 'FAC-DEMO-001',
            'subtotal' => 1000.00,
            'total' => 1190.00,
            'estado_pago' => 'pendiente',
        ]);

        $this->assertDatabaseHas('facturas', [
            'numero_factura' => 'FAC-DEMO-001',
            'total' => 1190.00,
        ]);
    }

    public function test_numero_factura_es_unico()
    {
        $cliente = Cliente::factory()->create(['nombre' => 'Restaurante La Cosecha']);
        $pedido1 = Pedido::factory()->for($cliente)->create();
        $pedido2 = Pedido::factory()->for($cliente)->create();

        Factura::create([
            'pedido_id' => $pedido1->id,
            'numero_factura' => 'FAC-UNICO-001',
            'subtotal' => 500.00,
            'total' => 595.00,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        Factura::create([
            'pedido_id' => $pedido2->id,
            'numero_factura' => 'FAC-UNICO-001',
            'subtotal' => 300.00,
            'total' => 357.00,
        ]);
    }

    public function test_factura_pertenece_a_un_pedido()
    {
        $cliente = Cliente::factory()->create(['nombre' => 'Plaza de Mercado Central']);
        $pedido = Pedido::factory()->for($cliente)->create();
        $factura = Factura::factory()->for($pedido)->create();

        $this->assertInstanceOf(Pedido::class, $factura->pedido);
        $this->assertEquals($pedido->id, $factura->pedido->id);
    }

    public function test_factura_puede_tener_pagos_asociados()
    {
        $cliente = Cliente::factory()->create(['nombre' => 'Supermercados El Campesino']);
        $pedido = Pedido::factory()->for($cliente)->create();
        $factura = Factura::factory()->for($pedido)->create();

        $pago = $factura->pagos()->create([
            'monto' => 1190.00,
            'fecha' => '2026-05-13',
            'metodo_pago' => 'transferencia',
        ]);

        $this->assertCount(1, $factura->pagos);
        $this->assertEquals(1190.00, $factura->pagos->first()->monto);
    }
}
