<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Personal;
use App\Models\Rol;
use App\Models\Maquinaria;
use App\Models\MantenimientoMaquinaria;
use App\Models\Proveedor;
use App\Models\Presupuesto;
use App\Models\Gasto;
use App\Models\Ingreso;
use App\Models\InformeFinanciero;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GestionRecursosModuleTest extends TestCase
{
    use RefreshDatabase;

    // ========================================================================
    // PERSONAL
    // ========================================================================

    public function test_puede_ver_listado_de_personal()
    {
        Personal::factory()->count(3)->create();

        $response = $this->get(route('personal.index'));

        $response->assertStatus(200);
        $response->assertViewHas('personal');
    }

    public function test_puede_crear_personal()
    {
        $response = $this->post(route('personal.store'), [
            'nombre' => 'Carlos Arturo Martínez',
            'habilidades' => 'Siembra y cosecha de hortalizas',
            'contrato' => '2026-01-15',
        ]);

        $response->assertRedirect(route('personal.index'));
        $this->assertDatabaseHas('empleados', [
            'nombre' => 'Carlos Arturo Martínez',
            'habilidades' => 'Siembra y cosecha de hortalizas',
        ]);
    }

    public function test_puede_crear_personal_con_rol()
    {
        $rol = Rol::create(['nombre' => 'Jefe de Cultivo', 'descripcion' => 'Supervisa labores agrícolas']);

        $response = $this->post(route('personal.store'), [
            'nombre' => 'María Fernanda Gómez',
            'rol_id' => $rol->id,
            'habilidades' => 'Supervisión de cultivos y sistemas de riego',
            'contrato' => '2026-02-01',
        ]);

        $response->assertRedirect(route('personal.index'));
        $this->assertDatabaseHas('empleados', [
            'nombre' => 'María Fernanda Gómez',
            'rol_id' => $rol->id,
        ]);
    }

    public function test_puede_ver_detalle_personal()
    {
        $personal = Personal::factory()->create();

        $response = $this->get(route('personal.show', $personal));

        $response->assertStatus(200);
        $response->assertViewHas('personal');
    }

    public function test_puede_actualizar_personal()
    {
        $personal = Personal::factory()->create([
            'nombre' => 'Nombre Original',
        ]);

        $response = $this->put(route('personal.update', $personal), [
            'nombre' => 'Diego Alejandro Muñoz',
            'habilidades' => 'Instalación y mantenimiento de sistemas de riego',
            'contrato' => $personal->contrato,
        ]);

        $response->assertRedirect(route('personal.index'));
        $this->assertEquals('Diego Alejandro Muñoz', $personal->fresh()->nombre);
    }

    public function test_puede_eliminar_personal()
    {
        $personal = Personal::factory()->create();

        $response = $this->delete(route('personal.destroy', $personal));

        $response->assertRedirect(route('personal.index'));
        $this->assertDatabaseMissing('empleados', ['id' => $personal->id]);
    }

    public function test_valida_campos_requeridos_personal()
    {
        $response = $this->post(route('personal.store'), [
            'nombre' => '',
        ]);

        $response->assertSessionHasErrors('nombre');
    }

    public function test_personal_pertenece_a_rol()
    {
        $rol = Rol::create(['nombre' => 'Tractorista', 'descripcion' => 'Opera maquinaria agrícola pesada']);
        $personal = Personal::factory()->for($rol)->create([
            'nombre' => 'Luis Fernando Rodríguez',
        ]);

        $this->assertInstanceOf(Rol::class, $personal->rol);
        $this->assertEquals($rol->id, $personal->rol->id);
        $this->assertEquals('Luis Fernando Rodríguez', $personal->nombre);
    }

    // ========================================================================
    // MAQUINARIA
    // ========================================================================

    public function test_puede_ver_listado_de_maquinaria()
    {
        Maquinaria::create(['nombre' => 'Tractor John Deere', 'tipo' => 'Tractor']);
        Maquinaria::create(['nombre' => 'Cosechadora', 'tipo' => 'Cosechadora']);

        $response = $this->get(route('maquinaria.index'));

        $response->assertStatus(200);
    }

    public function test_puede_crear_maquinaria()
    {
        $response = $this->post(route('maquinaria.store'), [
            'nombre' => 'Tractor Ford 6600',
            'tipo' => 'Tractor',
            'mantenimiento' => 'Cambio de aceite cada 200 horas',
        ]);

        $response->assertRedirect(route('maquinaria.index'));
        $this->assertDatabaseHas('maquinarias', [
            'nombre' => 'Tractor Ford 6600',
        ]);
    }

    public function test_puede_actualizar_maquinaria()
    {
        $maquinaria = Maquinaria::create([
            'nombre' => 'Nombre Original',
            'tipo' => 'Tractor',
        ]);

        $response = $this->put(route('maquinaria.update', $maquinaria), [
            'nombre' => 'Nombre Actualizado',
            'tipo' => 'Cosechadora',
            'mantenimiento' => $maquinaria->mantenimiento,
        ]);

        $response->assertRedirect(route('maquinaria.index'));
        $this->assertEquals('Nombre Actualizado', $maquinaria->fresh()->nombre);
    }

    public function test_puede_eliminar_maquinaria()
    {
        $maquinaria = Maquinaria::create(['nombre' => 'Tractor', 'tipo' => 'Tractor']);

        $response = $this->delete(route('maquinaria.destroy', $maquinaria));

        $response->assertRedirect(route('maquinaria.index'));
        $this->assertDatabaseMissing('maquinarias', ['id' => $maquinaria->id]);
    }

    // ========================================================================
    // MANTENIMIENTO DE MAQUINARIA
    // ========================================================================

    public function test_puede_ver_listado_de_mantenimientos()
    {
        $maquinaria = Maquinaria::create(['nombre' => 'Tractor', 'tipo' => 'Tractor']);
        MantenimientoMaquinaria::create([
            'maquinaria_id' => $maquinaria->id,
            'fecha' => '2026-03-01',
            'tipo' => 'Preventivo',
            'costo' => 250000.00,
        ]);

        $response = $this->get(route('mantenimiento.index'));

        $response->assertStatus(200);
    }

    public function test_puede_crear_mantenimiento()
    {
        $maquinaria = Maquinaria::create(['nombre' => 'Cosechadora', 'tipo' => 'Cosechadora']);

        $response = $this->post(route('mantenimiento.store'), [
            'maquinaria_id' => $maquinaria->id,
            'fecha' => '2026-04-10',
            'tipo' => 'Correctivo',
            'costo' => 500000.00,
        ]);

        $response->assertRedirect(route('mantenimiento.index'));
        $this->assertDatabaseHas('mantenimiento_maquinarias', [
            'maquinaria_id' => $maquinaria->id,
            'tipo' => 'Correctivo',
        ]);
    }

    public function test_puede_actualizar_mantenimiento()
    {
        $maquinaria = Maquinaria::create(['nombre' => 'Tractor', 'tipo' => 'Tractor']);
        $mantenimiento = MantenimientoMaquinaria::create([
            'maquinaria_id' => $maquinaria->id,
            'fecha' => '2026-01-01',
            'tipo' => 'Preventivo',
            'costo' => 100000.00,
        ]);

        $response = $this->put(route('mantenimiento.update', $mantenimiento), [
            'maquinaria_id' => $maquinaria->id,
            'fecha' => '2026-01-01',
            'tipo' => 'Correctivo',
            'costo' => 200000.00,
        ]);

        $response->assertRedirect(route('mantenimiento.index'));
        $this->assertEquals('Correctivo', $mantenimiento->fresh()->tipo);
    }

    public function test_puede_eliminar_mantenimiento()
    {
        $maquinaria = Maquinaria::create(['nombre' => 'Tractor', 'tipo' => 'Tractor']);
        $mantenimiento = MantenimientoMaquinaria::create([
            'maquinaria_id' => $maquinaria->id,
            'fecha' => '2026-01-01',
            'tipo' => 'Preventivo',
        ]);

        $response = $this->delete(route('mantenimiento.destroy', $mantenimiento));

        $response->assertRedirect(route('mantenimiento.index'));
        $this->assertDatabaseMissing('mantenimiento_maquinarias', ['id' => $mantenimiento->id]);
    }

    public function test_mantenimiento_pertenece_a_maquinaria()
    {
        $maquinaria = Maquinaria::create(['nombre' => 'Tractor', 'tipo' => 'Tractor']);
        $mantenimiento = MantenimientoMaquinaria::create([
            'maquinaria_id' => $maquinaria->id,
            'fecha' => '2026-01-01',
            'tipo' => 'Preventivo',
        ]);

        $this->assertInstanceOf(Maquinaria::class, $mantenimiento->maquinaria);
        $this->assertEquals($maquinaria->id, $mantenimiento->maquinaria->id);
    }

    // ========================================================================
    // PROVEEDOR
    // ========================================================================

    public function test_puede_ver_listado_de_proveedores()
    {
        Proveedor::create(['nombre' => 'Agroinsumos SAS', 'contacto' => 'ventas@agroinsumos.com']);
        Proveedor::create(['nombre' => 'Fertilizantes del Campo', 'contacto' => 'info@fertcampo.com']);

        $response = $this->get(route('proveedores.index'));

        $response->assertStatus(200);
    }

    public function test_puede_crear_proveedor()
    {
        $response = $this->post(route('proveedores.store'), [
            'nombre' => 'Semillas Premium Ltda.',
            'contacto' => 'pedidos@semillaspremium.com',
            'contrato' => 'Contrato anual de suministro',
        ]);

        $response->assertRedirect(route('proveedores.index'));
        $this->assertDatabaseHas('proveedores', [
            'nombre' => 'Semillas Premium Ltda.',
        ]);
    }

    public function test_puede_actualizar_proveedor()
    {
        $proveedor = Proveedor::create([
            'nombre' => 'Nombre Original',
            'contacto' => 'original@email.com',
        ]);

        $response = $this->put(route('proveedores.update', $proveedor), [
            'nombre' => 'Nombre Actualizado',
            'contacto' => 'actualizado@email.com',
        ]);

        $response->assertRedirect(route('proveedores.index'));
        $this->assertEquals('Nombre Actualizado', $proveedor->fresh()->nombre);
    }

    public function test_puede_eliminar_proveedor()
    {
        $proveedor = Proveedor::create(['nombre' => 'Proveedor Test', 'contacto' => 'test@test.com']);

        $response = $this->delete(route('proveedores.destroy', $proveedor));

        $response->assertRedirect(route('proveedores.index'));
        $this->assertDatabaseMissing('proveedores', ['id' => $proveedor->id]);
    }

    // ========================================================================
    // PRESUPUESTO
    // ========================================================================

    public function test_puede_ver_listado_de_presupuestos()
    {
        Presupuesto::create([
            'nombre' => 'Presupuesto Q1 2026',
            'fecha_inicio' => '2026-01-01',
            'fecha_fin' => '2026-03-31',
            'monto_total' => 50000000.00,
        ]);

        $response = $this->get(route('presupuestos.index'));

        $response->assertStatus(200);
    }

    public function test_puede_crear_presupuesto()
    {
        $response = $this->post(route('presupuestos.store'), [
            'nombre' => 'Presupuesto Cosecha 2026',
            'fecha_inicio' => '2026-06-01',
            'fecha_fin' => '2026-12-31',
            'monto_total' => 120000000.00,
        ]);

        $response->assertRedirect(route('presupuestos.index'));
        $this->assertDatabaseHas('presupuestos', [
            'nombre' => 'Presupuesto Cosecha 2026',
        ]);
    }

    public function test_valida_fecha_fin_posterior_a_inicio_en_presupuesto()
    {
        $response = $this->post(route('presupuestos.store'), [
            'nombre' => 'Presupuesto Inválido',
            'fecha_inicio' => '2026-12-31',
            'fecha_fin' => '2026-01-01',
            'monto_total' => 100000.00,
        ]);

        $response->assertSessionHasErrors('fecha_fin');
    }

    public function test_puede_actualizar_presupuesto()
    {
        $presupuesto = Presupuesto::create([
            'nombre' => 'Presupuesto Original',
            'fecha_inicio' => '2026-01-01',
            'fecha_fin' => '2026-03-31',
            'monto_total' => 10000000.00,
        ]);

        $response = $this->put(route('presupuestos.update', $presupuesto), [
            'nombre' => 'Presupuesto Actualizado',
            'fecha_inicio' => '2026-01-01',
            'fecha_fin' => '2026-03-31',
            'monto_total' => 15000000.00,
        ]);

        $response->assertRedirect(route('presupuestos.index'));
        $this->assertEquals(15000000.00, $presupuesto->fresh()->monto_total);
    }

    public function test_puede_eliminar_presupuesto()
    {
        $presupuesto = Presupuesto::create([
            'nombre' => 'Presupuesto Test',
            'fecha_inicio' => '2026-01-01',
            'fecha_fin' => '2026-03-31',
            'monto_total' => 5000000.00,
        ]);

        $response = $this->delete(route('presupuestos.destroy', $presupuesto));

        $response->assertRedirect(route('presupuestos.index'));
        $this->assertDatabaseMissing('presupuestos', ['id' => $presupuesto->id]);
    }

    // ========================================================================
    // GASTO
    // ========================================================================

    public function test_puede_ver_listado_de_gastos()
    {
        $proveedor = Proveedor::create(['nombre' => 'Agroinsumos SAS']);
        Gasto::create([
            'concepto' => 'Compra de fertilizantes',
            'monto' => 2500000.00,
            'fecha' => '2026-02-15',
            'proveedor_id' => $proveedor->id,
        ]);

        $response = $this->get(route('gastos.index'));

        $response->assertStatus(200);
        $response->assertViewHas('gastos');
    }

    public function test_puede_crear_gasto()
    {
        $proveedor = Proveedor::create(['nombre' => 'Fertilizantes del Campo']);

        $response = $this->post(route('gastos.store'), [
            'concepto' => 'Compra de urea',
            'monto' => 1800000.00,
            'fecha' => '2026-03-10',
            'proveedor_id' => $proveedor->id,
        ]);

        $response->assertRedirect(route('gastos.index'));
        $this->assertDatabaseHas('gastos', [
            'concepto' => 'Compra de urea',
            'monto' => 1800000.00,
        ]);
    }

    public function test_puede_actualizar_gasto()
    {
        $proveedor = Proveedor::create(['nombre' => 'Proveedor Test']);
        $gasto = Gasto::create([
            'concepto' => 'Concepto Original',
            'monto' => 100000.00,
            'fecha' => '2026-01-01',
            'proveedor_id' => $proveedor->id,
        ]);

        $response = $this->put(route('gastos.update', $gasto), [
            'concepto' => 'Concepto Actualizado',
            'monto' => 200000.00,
            'fecha' => '2026-01-01',
            'proveedor_id' => $proveedor->id,
        ]);

        $response->assertRedirect(route('gastos.index'));
        $this->assertEquals('Concepto Actualizado', $gasto->fresh()->concepto);
    }

    public function test_puede_eliminar_gasto()
    {
        $proveedor = Proveedor::create(['nombre' => 'Prov']);
        $gasto = Gasto::create([
            'concepto' => 'Gasto Test',
            'monto' => 50000.00,
            'fecha' => '2026-01-01',
            'proveedor_id' => $proveedor->id,
        ]);

        $response = $this->delete(route('gastos.destroy', $gasto));

        $response->assertRedirect(route('gastos.index'));
        $this->assertDatabaseMissing('gastos', ['id' => $gasto->id]);
    }

    public function test_gasto_pertenece_a_proveedor()
    {
        $proveedor = Proveedor::create(['nombre' => 'Agro Test']);
        $gasto = Gasto::create([
            'concepto' => 'Compra',
            'monto' => 100000.00,
            'fecha' => '2026-01-01',
            'proveedor_id' => $proveedor->id,
        ]);

        $this->assertInstanceOf(Proveedor::class, $gasto->proveedor);
        $this->assertEquals($proveedor->id, $gasto->proveedor->id);
    }

    // ========================================================================
    // INGRESO
    // ========================================================================

    public function test_puede_ver_listado_de_ingresos()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        Ingreso::create([
            'fuente' => 'Venta de Tomate',
            'monto' => 5000000.00,
            'fecha' => '2026-03-15',
            'pedido_id' => $pedido->id,
        ]);

        $response = $this->get(route('ingresos.index'));

        $response->assertStatus(200);
        $response->assertViewHas('ingresos');
    }

    public function test_puede_crear_ingreso()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();

        $response = $this->post(route('ingresos.store'), [
            'fuente' => 'Venta de Lechuga',
            'monto' => 1200000.00,
            'fecha' => '2026-04-01',
            'pedido_id' => $pedido->id,
        ]);

        $response->assertRedirect(route('ingresos.index'));
        $this->assertDatabaseHas('ingresos', [
            'fuente' => 'Venta de Lechuga',
            'monto' => 1200000.00,
        ]);
    }

    public function test_puede_crear_ingreso_sin_pedido()
    {
        $response = $this->post(route('ingresos.store'), [
            'fuente' => 'Venta directa',
            'monto' => 300000.00,
            'fecha' => '2026-04-01',
        ]);

        $response->assertRedirect(route('ingresos.index'));
        $this->assertDatabaseHas('ingresos', [
            'fuente' => 'Venta directa',
            'monto' => 300000.00,
        ]);
    }

    public function test_puede_actualizar_ingreso()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $ingreso = Ingreso::create([
            'fuente' => 'Fuente Original',
            'monto' => 1000000.00,
            'fecha' => '2026-01-01',
            'pedido_id' => $pedido->id,
        ]);

        $response = $this->put(route('ingresos.update', $ingreso), [
            'fuente' => 'Fuente Actualizada',
            'monto' => 2000000.00,
            'fecha' => '2026-01-01',
            'pedido_id' => $pedido->id,
        ]);

        $response->assertRedirect(route('ingresos.index'));
        $this->assertEquals('Fuente Actualizada', $ingreso->fresh()->fuente);
    }

    public function test_puede_eliminar_ingreso()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $ingreso = Ingreso::create([
            'fuente' => 'Venta',
            'monto' => 500000.00,
            'fecha' => '2026-01-01',
            'pedido_id' => $pedido->id,
        ]);

        $response = $this->delete(route('ingresos.destroy', $ingreso));

        $response->assertRedirect(route('ingresos.index'));
        $this->assertDatabaseMissing('ingresos', ['id' => $ingreso->id]);
    }

    public function test_ingreso_pertenece_a_pedido()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->for($cliente)->create();
        $ingreso = Ingreso::create([
            'fuente' => 'Venta',
            'monto' => 100000.00,
            'fecha' => '2026-01-01',
            'pedido_id' => $pedido->id,
        ]);

        $this->assertInstanceOf(Pedido::class, $ingreso->pedido);
        $this->assertEquals($pedido->id, $ingreso->pedido->id);
    }

    // ========================================================================
    // INFORME FINANCIERO
    // ========================================================================

    public function test_puede_ver_listado_de_informes()
    {
        InformeFinanciero::create([
            'tipo' => 'Mensual',
            'fecha_inicio' => '2026-01-01',
            'fecha_fin' => '2026-01-31',
            'ingresos_totales' => 10000000.00,
            'gastos_totales' => 7000000.00,
            'rentabilidad' => 3000000.00,
        ]);

        $response = $this->get(route('informes.index'));

        $response->assertStatus(200);
    }

    public function test_puede_crear_informe_financiero()
    {
        $response = $this->post(route('informes.store'), [
            'tipo' => 'Trimestral',
            'fecha_inicio' => '2026-01-01',
            'fecha_fin' => '2026-03-31',
            'ingresos_totales' => 50000000.00,
            'gastos_totales' => 35000000.00,
            'rentabilidad' => 15000000.00,
        ]);

        $response->assertRedirect(route('informes.index'));
        $this->assertDatabaseHas('informe_financieros', [
            'tipo' => 'Trimestral',
            'ingresos_totales' => 50000000.00,
        ]);
    }

    public function test_valida_fechas_en_informe_financiero()
    {
        $response = $this->post(route('informes.store'), [
            'tipo' => 'Mensual',
            'fecha_inicio' => '2026-12-31',
            'fecha_fin' => '2026-01-01',
            'ingresos_totales' => 1000000.00,
            'gastos_totales' => 500000.00,
        ]);

        $response->assertSessionHasErrors('fecha_fin');
    }

    public function test_valida_campos_requeridos_informe()
    {
        $response = $this->post(route('informes.store'), [
            'tipo' => '',
            'fecha_inicio' => '',
            'fecha_fin' => '',
            'ingresos_totales' => '',
            'gastos_totales' => '',
        ]);

        $response->assertSessionHasErrors(['tipo', 'fecha_inicio', 'fecha_fin', 'ingresos_totales', 'gastos_totales']);
    }

    public function test_puede_actualizar_informe_financiero()
    {
        $informe = InformeFinanciero::create([
            'tipo' => 'Mensual',
            'fecha_inicio' => '2026-01-01',
            'fecha_fin' => '2026-01-31',
            'ingresos_totales' => 5000000.00,
            'gastos_totales' => 3000000.00,
            'rentabilidad' => 2000000.00,
        ]);

        $response = $this->put(route('informes.update', $informe), [
            'tipo' => 'Mensual Actualizado',
            'fecha_inicio' => '2026-01-01',
            'fecha_fin' => '2026-01-31',
            'ingresos_totales' => 8000000.00,
            'gastos_totales' => 4000000.00,
            'rentabilidad' => 4000000.00,
        ]);

        $response->assertRedirect(route('informes.index'));
        $this->assertEquals(8000000.00, $informe->fresh()->ingresos_totales);
    }

    public function test_puede_eliminar_informe_financiero()
    {
        $informe = InformeFinanciero::create([
            'tipo' => 'Test',
            'fecha_inicio' => '2026-01-01',
            'fecha_fin' => '2026-01-31',
            'ingresos_totales' => 1000000.00,
            'gastos_totales' => 500000.00,
        ]);

        $response = $this->delete(route('informes.destroy', $informe));

        $response->assertRedirect(route('informes.index'));
        $this->assertDatabaseMissing('informe_financieros', ['id' => $informe->id]);
    }

    // ========================================================================
    // ROL
    // ========================================================================

    public function test_puede_ver_listado_de_roles()
    {
        Rol::create(['nombre' => 'Administrador', 'descripcion' => 'Acceso total']);
        Rol::create(['nombre' => 'Operario', 'descripcion' => 'Labores de campo']);

        $response = $this->get(route('roles.index'));

        $response->assertStatus(200);
        $response->assertViewHas('roles');
    }

    public function test_puede_crear_rol()
    {
        $response = $this->post(route('roles.store'), [
            'nombre' => 'Supervisor',
            'descripcion' => 'Supervisa labores agrícolas',
        ]);

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseHas('rols', [
            'nombre' => 'Supervisor',
        ]);
    }

    public function test_puede_actualizar_rol()
    {
        $rol = Rol::create(['nombre' => 'Rol Original', 'descripcion' => 'Descripción original']);

        $response = $this->put(route('roles.update', $rol), [
            'nombre' => 'Rol Actualizado',
            'descripcion' => 'Descripción actualizada',
        ]);

        $response->assertRedirect(route('roles.index'));
        $this->assertEquals('Rol Actualizado', $rol->fresh()->nombre);
    }

    public function test_no_puede_eliminar_rol_con_personal_asociado()
    {
        $rol = Rol::create(['nombre' => 'Jefe', 'descripcion' => 'Jefatura']);
        Personal::factory()->for($rol)->create();

        $response = $this->delete(route('roles.destroy', $rol));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('rols', ['id' => $rol->id]);
    }

    public function test_puede_eliminar_rol_sin_personal_asociado()
    {
        $rol = Rol::create(['nombre' => 'Temporal', 'descripcion' => 'Rol sin personal']);

        $response = $this->delete(route('roles.destroy', $rol));

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseMissing('rols', ['id' => $rol->id]);
    }

    public function test_rol_tiene_personal_asociado()
    {
        $rol = Rol::create(['nombre' => 'Operario', 'descripcion' => 'Campo']);
        $personal1 = Personal::factory()->for($rol)->create();
        $personal2 = Personal::factory()->for($rol)->create();

        $this->assertCount(2, $rol->empleados);
        $this->assertInstanceOf(Personal::class, $rol->empleados->first());
    }
}
