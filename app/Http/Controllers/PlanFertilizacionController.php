<?php

namespace App\Http\Controllers;

use App\Models\PlanFertilizacion;
use App\Models\Cultivo;
use App\Models\InsumoAgricola;
use App\Models\EtapaFenologica;
use Illuminate\Http\Request;

class PlanFertilizacionController extends Controller
{
    public function index()
    {
        $planes = PlanFertilizacion::with(['cultivo', 'insumoAgricola', 'etapaFenologica'])->get();
        return view('planes_fertilizacion.index', compact('planes'));
    }

    public function create()
    {
        $cultivos = Cultivo::all();
        $fertilizantes = InsumoAgricola::all();
        $etapas = EtapaFenologica::all();
        return view('planes_fertilizacion.create', compact('cultivos', 'fertilizantes', 'etapas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'insumo_agricola_id' => 'required|exists:fertilizantes,id',
            'etapa_fenologica_id' => 'nullable|exists:etapa_fenologicas,id',
            'dosis' => 'required|numeric|min:0',
            'metodo' => 'nullable|string|max:255',
        ]);

        PlanFertilizacion::create($validated);

        return redirect()->route('planes-fertilizacion.index')
            ->with('success', 'Plan de fertilización creado exitosamente.');
    }

    public function show(PlanFertilizacion $plan)
    {
        $plan->load(['cultivo', 'insumoAgricola', 'etapaFenologica']);
        return view('planes_fertilizacion.show', compact('plan'));
    }

    public function edit(PlanFertilizacion $plan)
    {
        $cultivos = Cultivo::all();
        $fertilizantes = InsumoAgricola::all();
        $etapas = EtapaFenologica::all();
        return view('planes_fertilizacion.edit', compact('plan', 'cultivos', 'fertilizantes', 'etapas'));
    }

    public function update(Request $request, PlanFertilizacion $plan)
    {
        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'insumo_agricola_id' => 'required|exists:fertilizantes,id',
            'etapa_fenologica_id' => 'nullable|exists:etapa_fenologicas,id',
            'dosis' => 'required|numeric|min:0',
            'metodo' => 'nullable|string|max:255',
        ]);

        $plan->update($validated);

        return redirect()->route('planes-fertilizacion.index')
            ->with('success', 'Plan de fertilización actualizado exitosamente.');
    }

    public function destroy(PlanFertilizacion $plan)
    {
        $plan->delete();
        return redirect()->route('planes-fertilizacion.index')
            ->with('success', 'Plan de fertilización eliminado exitosamente.');
    }
}