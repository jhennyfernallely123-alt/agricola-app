<?php

namespace App\Http\Controllers;

use App\Models\EtapaFenologica;
use App\Models\Cultivo;
use Illuminate\Http\Request;

class EtapaFenologicaController extends Controller
{
    public function index()
    {
        $etapas = EtapaFenologica::with(['cultivo'])->get();
        return view('etapas_fenologicas.index', compact('etapas'));
    }

    public function create()
    {
        $cultivos = Cultivo::all();
        return view('etapas_fenologicas.create', compact('cultivos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'requerimientos_especificos' => 'nullable|string',
        ]);

        EtapaFenologica::create($validated);

        return redirect()->route('etapas-fenologicas.index')
            ->with('success', 'Etapa fenológica creada exitosamente.');
    }

    public function show(EtapaFenologica $etapa)
    {
        $etapa->load('cultivo');
        return view('etapas_fenologicas.show', compact('etapa'));
    }

    public function edit(EtapaFenologica $etapa)
    {
        $cultivos = Cultivo::all();
        return view('etapas_fenologicas.edit', compact('etapa', 'cultivos'));
    }

    public function update(Request $request, EtapaFenologica $etapa)
    {
        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'requerimientos_especificos' => 'nullable|string',
        ]);

        $etapa->update($validated);

        return redirect()->route('etapas-fenologicas.index')
            ->with('success', 'Etapa fenológica actualizada exitosamente.');
    }

    public function destroy(EtapaFenologica $etapa)
    {
        if ($etapa->planesFertilizacion()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la etapa fenológica porque tiene planes de fertilización asociados.');
        }

        $etapa->delete();
        return redirect()->route('etapas-fenologicas.index')
            ->with('success', 'Etapa fenológica eliminada exitosamente.');
    }
}