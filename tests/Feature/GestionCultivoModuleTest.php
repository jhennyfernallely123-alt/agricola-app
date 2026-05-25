<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Parcela;
use App\Models\Cultivo;
use App\Models\SistemaRiego;
use App\Models\InsumoAgricola;
use App\Models\PlanCultivo;
use App\Models\EtapaFenologica;
use App\Models\LaborAgricola;
use App\Models\PlanFertilizacion;
use App\Models\ControlPlagasEnfermedades;
use App\Models\Personal;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GestionCultivoModuleTest extends TestCase
{
    use RefreshDatabase;

    // ========================================================================
    // PARCELA
    // ========================================================================

    public function test_puede_ver_listado_de_parcelas()
    {
        Parcela::factory()->count(3)->create();

        $response = $this->get(route('parcelas.index'));

        $response->assertStatus(200);
        $response->assertViewHas('parcelas');
    }

    public function test_puede_ver_formulario_creacion_parcela()
    {
        $response = $this->get(route('parcelas.create'));
        $response->assertStatus(200);
    }

    public function test_puede_crear_parcela()
    {
        $response = $this->post(route('parcelas.store'), [
            'nombre' => 'La Esperanza',
            'area' => 45.5,
            'historial_uso' => 'Cultivo rotativo de hortalizas y frutales durante los últimos 10 años',
            'analisis_suelo' => 'pH 6.2, materia orgánica 3.5%, textura franco-arcillosa',
            'potencial_productivo' => 'Alto',
        ]);

        $response->assertRedirect(route('parcelas.index'));
        $this->assertDatabaseHas('parcelas', [
            'nombre' => 'La Esperanza',
            'area' => 45.5,
        ]);
    }

    public function test_puede_ver_detalle_parcela()
    {
        $parcela = Parcela::factory()->create();

        $response = $this->get(route('parcelas.show', $parcela));

        $response->assertStatus(200);
        $response->assertViewHas('parcela');
    }

    public function test_puede_ver_formulario_edicion_parcela()
    {
        $parcela = Parcela::factory()->create();

        $response = $this->get(route('parcelas.edit', $parcela));

        $response->assertStatus(200);
        $response->assertViewHas('parcela');
    }

    public function test_puede_actualizar_parcela()
    {
        $parcela = Parcela::factory()->create([
            'nombre' => 'Nombre Original',
        ]);

        $response = $this->put(route('parcelas.update', $parcela), [
            'nombre' => 'El Porvenir',
            'area' => $parcela->area,
        ]);

        $response->assertRedirect(route('parcelas.index'));
        $this->assertEquals('El Porvenir', $parcela->fresh()->nombre);
    }

    public function test_puede_eliminar_parcela_sin_cultivos()
    {
        $parcela = Parcela::factory()->create();

        $response = $this->delete(route('parcelas.destroy', $parcela));

        $response->assertRedirect(route('parcelas.index'));
        $this->assertDatabaseMissing('parcelas', ['id' => $parcela->id]);
    }

    public function test_no_puede_eliminar_parcela_con_cultivos_asociados()
    {
        $parcela = Parcela::factory()->create();
        Cultivo::factory()->for($parcela)->create();

        $response = $this->delete(route('parcelas.destroy', $parcela));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('parcelas', ['id' => $parcela->id]);
    }

    public function test_valida_campos_requeridos_parcela()
    {
        $response = $this->post(route('parcelas.store'), [
            'nombre' => '',
            'area' => '',
        ]);

        $response->assertSessionHasErrors(['nombre', 'area']);
    }

    // ========================================================================
    // CULTIVO
    // ========================================================================

    public function test_puede_ver_listado_de_cultivos()
    {
        $parcela = Parcela::factory()->create();
        Cultivo::factory()->count(3)->for($parcela)->create();

        $response = $this->get(route('cultivos.index'));

        $response->assertStatus(200);
        $response->assertViewHas('cultivos');
    }

    public function test_puede_crear_cultivo()
    {
        $parcela = Parcela::factory()->create();

        $response = $this->post(route('cultivos.store'), [
            'nombre' => 'Tomate Chonto',
            'variedad' => 'Híbrida',
            'requerimientos' => 'Riego diario, pH 6.0-6.5, temperatura 18-28°C',
            'parcela_id' => $parcela->id,
        ]);

        $response->assertRedirect(route('cultivos.index'));
        $this->assertDatabaseHas('cultivos', [
            'nombre' => 'Tomate Chonto',
            'parcela_id' => $parcela->id,
        ]);
    }

    public function test_puede_ver_detalle_cultivo()
    {
        $cultivo = Cultivo::factory()->create();

        $response = $this->get(route('cultivos.show', $cultivo));

        $response->assertStatus(200);
        $response->assertViewHas('cultivo');
    }

    public function test_puede_actualizar_cultivo()
    {
        $parcela = Parcela::factory()->create();
        $cultivo = Cultivo::factory()->for($parcela)->create([
            'nombre' => 'Nombre Original',
        ]);

        $response = $this->put(route('cultivos.update', $cultivo), [
            'nombre' => 'Mora de Castilla',
            'variedad' => 'Orgánica',
            'requerimientos' => 'Riego cada 2 días, pH 5.5-6.5, sistema de espaldera',
            'parcela_id' => $parcela->id,
        ]);

        $response->assertRedirect(route('cultivos.index'));
        $this->assertEquals('Mora de Castilla', $cultivo->fresh()->nombre);
    }

    public function test_no_puede_eliminar_cultivo_con_etapas_asociadas()
    {
        $cultivo = Cultivo::factory()->create();
        EtapaFenologica::create([
            'cultivo_id' => $cultivo->id,
            'nombre' => 'Floración',
            'fecha_inicio' => '2026-01-15',
        ]);

        $response = $this->delete(route('cultivos.destroy', $cultivo));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('cultivos', ['id' => $cultivo->id]);
    }

    public function test_no_puede_eliminar_cultivo_con_labores_asociadas()
    {
        $cultivo = Cultivo::factory()->create();
        $personal = Personal::factory()->create();
        LaborAgricola::create([
            'cultivo_id' => $cultivo->id,
            'empleado_id' => $personal->id,
            'tipo' => 'Riego',
            'fecha' => '2026-01-15',
        ]);

        $response = $this->delete(route('cultivos.destroy', $cultivo));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('cultivos', ['id' => $cultivo->id]);
    }

    public function test_puede_eliminar_cultivo_sin_relaciones()
    {
        $cultivo = Cultivo::factory()->create();

        $response = $this->delete(route('cultivos.destroy', $cultivo));

        $response->assertRedirect(route('cultivos.index'));
        $this->assertDatabaseMissing('cultivos', ['id' => $cultivo->id]);
    }

    public function test_valida_campos_requeridos_cultivo()
    {
        $response = $this->post(route('cultivos.store'), [
            'nombre' => '',
            'parcela_id' => '',
        ]);

        $response->assertSessionHasErrors(['nombre', 'parcela_id']);
    }

    public function test_cultivo_pertenece_a_parcela()
    {
        $parcela = Parcela::factory()->create();
        $cultivo = Cultivo::factory()->for($parcela)->create();

        $this->assertInstanceOf(Parcela::class, $cultivo->parcela);
        $this->assertEquals($parcela->id, $cultivo->parcela->id);
    }

    // ========================================================================
    // SISTEMA DE RIEGO
    // ========================================================================

    public function test_puede_ver_listado_de_sistemas_riego()
    {
        SistemaRiego::factory()->count(3)->create();

        $response = $this->get(route('sistemas-riego.index'));

        $response->assertStatus(200);
        $response->assertViewHas('sistemas');
    }

    public function test_puede_crear_sistema_riego()
    {
        $response = $this->post(route('sistemas-riego.store'), [
            'tipo' => 'Aspersión',
            'fuente' => 'Pozo profundo',
        ]);

        $response->assertRedirect(route('sistemas-riego.index'));
        $this->assertDatabaseHas('sistema_riegos', [
            'tipo' => 'Aspersión',
        ]);
    }

    public function test_no_puede_eliminar_sistema_riego_con_cultivos_asociados()
    {
        $sistema = SistemaRiego::factory()->create();
        $cultivo = Cultivo::factory()->create();
        $sistema->cultivos()->attach($cultivo->id);

        $response = $this->delete(route('sistemas-riego.destroy', $sistema));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('sistema_riegos', ['id' => $sistema->id]);
    }

    public function test_sistema_riego_puede_tener_cultivos()
    {
        $sistema = SistemaRiego::factory()->create();
        $cultivo1 = Cultivo::factory()->create();
        $cultivo2 = Cultivo::factory()->create();

        $sistema->cultivos()->attach([$cultivo1->id, $cultivo2->id]);

        $this->assertCount(2, $sistema->cultivos);
    }

    // ========================================================================
    // FERTILIZANTE (InsumoAgricola model, tabla fertilizantes)
    // ========================================================================

    public function test_puede_ver_listado_de_fertilizantes()
    {
        InsumoAgricola::create(['nombre' => 'NPK 15-15-15', 'tipo' => 'Granulado']);
        InsumoAgricola::create(['nombre' => 'Urea', 'tipo' => 'Granulado']);
        InsumoAgricola::create(['nombre' => 'Fertilizante Líquido', 'tipo' => 'Líquido']);

        $response = $this->get(route('fertilizantes.index'));

        $response->assertStatus(200);
    }

    public function test_puede_crear_fertilizante()
    {
        $response = $this->post(route('fertilizantes.store'), [
            'nombre' => 'Fertilizante NPK 15-15-15',
            'tipo' => 'Granulado',
            'descripcion' => 'Fertilizante balanceado para cultivos',
        ]);

        $response->assertRedirect(route('fertilizantes.index'));
        $this->assertDatabaseHas('fertilizantes', [
            'nombre' => 'Fertilizante NPK 15-15-15',
        ]);
    }

    public function test_no_puede_eliminar_fertilizante_con_cultivos_asociados()
    {
        $fertilizante = InsumoAgricola::create([
            'nombre' => 'Fertilizante Test',
            'tipo' => 'Líquido',
        ]);
        $cultivo = Cultivo::factory()->create();
        $fertilizante->cultivos()->attach($cultivo->id);

        $response = $this->delete(route('fertilizantes.destroy', $fertilizante));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('fertilizantes', ['id' => $fertilizante->id]);
    }

    public function test_fertilizante_puede_tener_cultivos()
    {
        $fertilizante = InsumoAgricola::create([
            'nombre' => 'Urea',
            'tipo' => 'Granulado',
        ]);
        $cultivo1 = Cultivo::factory()->create();
        $cultivo2 = Cultivo::factory()->create();

        $fertilizante->cultivos()->attach([$cultivo1->id, $cultivo2->id]);

        $this->assertCount(2, $fertilizante->cultivos);
    }

    // ========================================================================
    // PLAN DE CULTIVO
    // ========================================================================

    public function test_puede_ver_listado_de_planes_cultivo()
    {
        $cultivo = Cultivo::factory()->create();
        PlanCultivo::factory()->count(3)->for($cultivo)->create();

        $response = $this->get(route('planes-cultivo.index'));

        $response->assertStatus(200);
    }

    public function test_puede_crear_plan_cultivo()
    {
        $cultivo = Cultivo::factory()->create();

        $response = $this->post(route('planes-cultivo.store'), [
            'cultivo_id' => $cultivo->id,
            'fecha_inicio' => '2026-01-01',
            'fecha_fin_prevista' => '2026-06-30',
            'objetivo_produccion' => 5000.00,
        ]);

        $response->assertRedirect(route('planes-cultivo.index'));
        $this->assertDatabaseHas('plan_cultivos', [
            'cultivo_id' => $cultivo->id,
            'objetivo_produccion' => 5000.00,
        ]);
    }

    public function test_valida_fecha_fin_prevista_posterior_a_fecha_inicio_en_plan_cultivo()
    {
        $cultivo = Cultivo::factory()->create();

        $response = $this->post(route('planes-cultivo.store'), [
            'cultivo_id' => $cultivo->id,
            'fecha_inicio' => '2026-06-30',
            'fecha_fin_prevista' => '2026-01-01',
        ]);

        $response->assertSessionHasErrors('fecha_fin_prevista');
    }

    public function test_puede_actualizar_plan_cultivo()
    {
        $cultivo = Cultivo::factory()->create();
        $plan = PlanCultivo::factory()->for($cultivo)->create();

        $response = $this->put(route('planes-cultivo.update', $plan), [
            'cultivo_id' => $cultivo->id,
            'fecha_inicio' => '2026-01-01',
            'fecha_fin_prevista' => '2026-06-30',
            'objetivo_produccion' => 8000.00,
        ]);

        $response->assertRedirect(route('planes-cultivo.index'));
        $this->assertEquals(8000.00, $plan->fresh()->objetivo_produccion);
    }

    public function test_puede_eliminar_plan_cultivo()
    {
        $cultivo = Cultivo::factory()->create();
        $plan = PlanCultivo::factory()->for($cultivo)->create();

        $response = $this->delete(route('planes-cultivo.destroy', $plan));

        $response->assertRedirect(route('planes-cultivo.index'));
        $this->assertDatabaseMissing('plan_cultivos', ['id' => $plan->id]);
    }

    // ========================================================================
    // ETAPA FENOLÓGICA
    // ========================================================================

    public function test_puede_ver_listado_de_etapas_fenologicas()
    {
        $cultivo = Cultivo::factory()->create();
        EtapaFenologica::factory()->count(3)->for($cultivo)->create();

        $response = $this->get(route('etapas-fenologicas.index'));

        $response->assertStatus(200);
    }

    public function test_puede_crear_etapa_fenologica()
    {
        $cultivo = Cultivo::factory()->create();

        $response = $this->post(route('etapas-fenologicas.store'), [
            'cultivo_id' => $cultivo->id,
            'nombre' => 'Floración',
            'fecha_inicio' => '2026-02-15',
            'requerimientos_especificos' => 'Alta humedad',
        ]);

        $response->assertRedirect(route('etapas-fenologicas.index'));
        $this->assertDatabaseHas('etapa_fenologicas', [
            'cultivo_id' => $cultivo->id,
            'nombre' => 'Floración',
        ]);
    }

    public function test_no_puede_eliminar_etapa_con_planes_fertilizacion_asociados()
    {
        $cultivo = Cultivo::factory()->create();
        $etapa = EtapaFenologica::factory()->for($cultivo)->create();
        $fertilizante = InsumoAgricola::create(['nombre' => 'NPK', 'tipo' => 'Granulado']);
        PlanFertilizacion::create([
            'cultivo_id' => $cultivo->id,
            'insumo_agricola_id' => $fertilizante->id,
            'etapa_fenologica_id' => $etapa->id,
            'dosis' => 50.00,
            'metodo' => 'Manual',
        ]);

        $response = $this->delete(route('etapas-fenologicas.destroy', $etapa));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('etapa_fenologicas', ['id' => $etapa->id]);
    }

    public function test_etapa_fenologica_pertenece_a_cultivo()
    {
        $cultivo = Cultivo::factory()->create();
        $etapa = EtapaFenologica::factory()->for($cultivo)->create();

        $this->assertInstanceOf(Cultivo::class, $etapa->cultivo);
        $this->assertEquals($cultivo->id, $etapa->cultivo->id);
    }

    // ========================================================================
    // LABOR AGRÍCOLA
    // ========================================================================

    public function test_puede_ver_listado_de_labores_agricolas()
    {
        $cultivo = Cultivo::factory()->create();
        $personal = Personal::factory()->create();
        LaborAgricola::create([
            'cultivo_id' => $cultivo->id,
            'empleado_id' => $personal->id,
            'tipo' => 'Riego',
            'fecha' => '2026-01-15',
        ]);

        $response = $this->get(route('labores-agricolas.index'));

        $response->assertStatus(200);
        $response->assertViewHas('labores');
    }

    public function test_puede_crear_labor_agricola()
    {
        $cultivo = Cultivo::factory()->create();
        $personal = Personal::factory()->create();

        $response = $this->post(route('labores-agricolas.store'), [
            'cultivo_id' => $cultivo->id,
            'empleado_id' => $personal->id,
            'tipo' => 'Fertilización',
            'fecha' => '2026-03-01',
            'costo' => 150000.00,
        ]);

        $response->assertRedirect(route('labores-agricolas.index'));
        $this->assertDatabaseHas('labor_agricolas', [
            'cultivo_id' => $cultivo->id,
            'empleado_id' => $personal->id,
            'tipo' => 'Fertilización',
        ]);
    }

    public function test_puede_actualizar_labor_agricola()
    {
        $cultivo = Cultivo::factory()->create();
        $personal = Personal::factory()->create();
        $labor = LaborAgricola::create([
            'cultivo_id' => $cultivo->id,
            'empleado_id' => $personal->id,
            'tipo' => 'Riego',
            'fecha' => '2026-01-15',
        ]);

        $response = $this->put(route('labores-agricolas.update', $labor), [
            'cultivo_id' => $cultivo->id,
            'empleado_id' => $personal->id,
            'tipo' => 'Fertilización',
            'fecha' => '2026-01-15',
            'costo' => $labor->costo,
        ]);

        $response->assertRedirect(route('labores-agricolas.index'));
        $this->assertEquals('Fertilización', $labor->fresh()->tipo);
    }

    public function test_puede_eliminar_labor_agricola()
    {
        $cultivo = Cultivo::factory()->create();
        $personal = Personal::factory()->create();
        $labor = LaborAgricola::create([
            'cultivo_id' => $cultivo->id,
            'empleado_id' => $personal->id,
            'tipo' => 'Riego',
            'fecha' => '2026-01-15',
        ]);

        $response = $this->delete(route('labores-agricolas.destroy', $labor));

        $response->assertRedirect(route('labores-agricolas.index'));
        $this->assertDatabaseMissing('labor_agricolas', ['id' => $labor->id]);
    }

    public function test_labor_agricola_pertenece_a_cultivo_y_empleado()
    {
        $cultivo = Cultivo::factory()->create();
        $personal = Personal::factory()->create();
        $labor = LaborAgricola::create([
            'cultivo_id' => $cultivo->id,
            'empleado_id' => $personal->id,
            'tipo' => 'Poda',
            'fecha' => '2026-02-01',
        ]);

        $this->assertInstanceOf(Cultivo::class, $labor->cultivo);
        $this->assertInstanceOf(Personal::class, $labor->empleado);
        $this->assertEquals($cultivo->id, $labor->cultivo->id);
        $this->assertEquals($personal->id, $labor->empleado->id);
    }

    // ========================================================================
    // PLAN DE FERTILIZACIÓN
    // ========================================================================

    public function test_puede_ver_listado_de_planes_fertilizacion()
    {
        $cultivo = Cultivo::factory()->create();
        $fertilizante = InsumoAgricola::create(['nombre' => 'NPK', 'tipo' => 'Granulado']);

        $response = $this->get(route('planes-fertilizacion.index'));

        $response->assertStatus(200);
    }

    public function test_puede_crear_plan_fertilizacion()
    {
        $cultivo = Cultivo::factory()->create();
        $fertilizante = InsumoAgricola::create(['nombre' => 'Urea', 'tipo' => 'Granulado']);

        $response = $this->post(route('planes-fertilizacion.store'), [
            'cultivo_id' => $cultivo->id,
            'insumo_agricola_id' => $fertilizante->id,
            'dosis' => 100.50,
            'metodo' => 'Al voleo',
        ]);

        $response->assertRedirect(route('planes-fertilizacion.index'));
        $this->assertDatabaseHas('plan_fertilizacions', [
            'cultivo_id' => $cultivo->id,
            'insumo_agricola_id' => $fertilizante->id,
            'dosis' => 100.50,
        ]);
    }

    public function test_puede_actualizar_plan_fertilizacion()
    {
        $cultivo = Cultivo::factory()->create();
        $fertilizante = InsumoAgricola::create(['nombre' => 'NPK', 'tipo' => 'Granulado']);
        $plan = PlanFertilizacion::create([
            'cultivo_id' => $cultivo->id,
            'insumo_agricola_id' => $fertilizante->id,
            'dosis' => 50.00,
        ]);

        $response = $this->put(route('planes-fertilizacion.update', $plan), [
            'cultivo_id' => $cultivo->id,
            'insumo_agricola_id' => $fertilizante->id,
            'dosis' => 80.00,
        ]);

        $response->assertRedirect(route('planes-fertilizacion.index'));
        $this->assertEquals(80.00, $plan->fresh()->dosis);
    }

    public function test_puede_eliminar_plan_fertilizacion()
    {
        $cultivo = Cultivo::factory()->create();
        $fertilizante = InsumoAgricola::create(['nombre' => 'Urea', 'tipo' => 'Granulado']);
        $plan = PlanFertilizacion::create([
            'cultivo_id' => $cultivo->id,
            'insumo_agricola_id' => $fertilizante->id,
            'dosis' => 30.00,
        ]);

        $response = $this->delete(route('planes-fertilizacion.destroy', $plan));

        $response->assertRedirect(route('planes-fertilizacion.index'));
        $this->assertDatabaseMissing('plan_fertilizacions', ['id' => $plan->id]);
    }

    public function test_plan_fertilizacion_pertenece_a_etapa_fenologica()
    {
        $cultivo = Cultivo::factory()->create();
        $etapa = EtapaFenologica::factory()->for($cultivo)->create();
        $fertilizante = InsumoAgricola::create(['nombre' => 'NPK', 'tipo' => 'Granulado']);
        $plan = PlanFertilizacion::create([
            'cultivo_id' => $cultivo->id,
            'insumo_agricola_id' => $fertilizante->id,
            'etapa_fenologica_id' => $etapa->id,
            'dosis' => 40.00,
        ]);

        $this->assertInstanceOf(EtapaFenologica::class, $plan->etapaFenologica);
        $this->assertEquals($etapa->id, $plan->etapaFenologica->id);
    }

    // ========================================================================
    // CONTROL DE PLAGAS
    // ========================================================================

    public function test_puede_ver_listado_de_control_plagas()
    {
        $cultivo = Cultivo::factory()->create();
        ControlPlagasEnfermedades::factory()->count(3)->for($cultivo)->create();

        $response = $this->get(route('plagas.index'));

        $response->assertStatus(200);
    }

    public function test_puede_crear_control_plagas()
    {
        $cultivo = Cultivo::factory()->create();

        $response = $this->post(route('plagas.store'), [
            'cultivo_id' => $cultivo->id,
            'tipo' => 'Plaga',
            'nombre' => 'Mosca blanca',
            'fecha_deteccion' => '2026-04-10',
            'tratamiento_aplicado' => 'Aplicación de insecticida orgánico',
        ]);

        $response->assertRedirect(route('plagas.index'));
        $this->assertDatabaseHas('control_plagas_enfermedades', [
            'cultivo_id' => $cultivo->id,
            'nombre' => 'Mosca blanca',
        ]);
    }

    public function test_puede_actualizar_control_plagas()
    {
        $cultivo = Cultivo::factory()->create();
        $plaga = ControlPlagasEnfermedades::factory()->for($cultivo)->create();

        $response = $this->put(route('plagas.update', $plaga), [
            'cultivo_id' => $cultivo->id,
            'tipo' => 'Enfermedad',
            'nombre' => 'Mildiu actualizado',
            'fecha_deteccion' => $plaga->fecha_deteccion,
        ]);

        $response->assertRedirect(route('plagas.index'));
        $this->assertEquals('Mildiu actualizado', $plaga->fresh()->nombre);
    }

    public function test_puede_eliminar_control_plagas()
    {
        $cultivo = Cultivo::factory()->create();
        $plaga = ControlPlagasEnfermedades::factory()->for($cultivo)->create();

        $response = $this->delete(route('plagas.destroy', $plaga));

        $response->assertRedirect(route('plagas.index'));
        $this->assertDatabaseMissing('control_plagas_enfermedades', ['id' => $plaga->id]);
    }

    public function test_control_plagas_pertenece_a_cultivo()
    {
        $cultivo = Cultivo::factory()->create();
        $plaga = ControlPlagasEnfermedades::factory()->for($cultivo)->create();

        $this->assertInstanceOf(Cultivo::class, $plaga->cultivo);
        $this->assertEquals($cultivo->id, $plaga->cultivo->id);
    }

    // ========================================================================
    // RELACIONES GENERALES
    // ========================================================================

    public function test_parcela_tiene_muchos_cultivos()
    {
        $parcela = Parcela::factory()->create();
        Cultivo::factory()->count(3)->for($parcela)->create();

        $this->assertCount(3, $parcela->cultivos);
        $this->assertInstanceOf(Cultivo::class, $parcela->cultivos->first());
    }

    public function test_cultivo_tiene_multiples_relaciones()
    {
        $cultivo = Cultivo::factory()->create();
        $personal = Personal::factory()->create();

        // Etapas
        $etapa = EtapaFenologica::factory()->for($cultivo)->create();
        // Labores
        LaborAgricola::create(['cultivo_id' => $cultivo->id, 'empleado_id' => $personal->id, 'tipo' => 'Riego', 'fecha' => '2026-01-15']);
        // Plan fertilizacion
        $fertilizante = InsumoAgricola::create(['nombre' => 'NPK', 'tipo' => 'Granulado']);
        PlanFertilizacion::create(['cultivo_id' => $cultivo->id, 'insumo_agricola_id' => $fertilizante->id, 'dosis' => 50]);
        // Control plagas
        ControlPlagasEnfermedades::factory()->for($cultivo)->create();

        $cultivo->loadCount(['etapasFenologicas', 'laboresAgricolas', 'planesFertilizacion', 'controlesPlagas']);

        $this->assertGreaterThanOrEqual(1, $cultivo->etapas_fenologicas_count);
        $this->assertGreaterThanOrEqual(1, $cultivo->labores_agricolas_count);
        $this->assertGreaterThanOrEqual(1, $cultivo->planes_fertilizacion_count);
        $this->assertGreaterThanOrEqual(1, $cultivo->controles_plagas_count);
    }
}
