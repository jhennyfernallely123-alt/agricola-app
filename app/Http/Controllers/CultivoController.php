<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use App\Models\Parcela;
use Illuminate\Http\Request;

class CultivoController extends Controller
{
    public function index()
    {
        $cultivos = Cultivo::with(['parcela'])->get();
        return view('cultivos.index', compact('cultivos'));
    }

    public function create()
    {
        $parcelas = Parcela::all();
        return view('cultivos.create', compact('parcelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'variedad' => 'nullable|string|max:255',
            'requerimientos' => 'nullable|string',
            'parcela_id' => 'required|exists:parcelas,id',
        ]);

        Cultivo::create($validated);

        return redirect()->route('cultivos.index')
            ->with('success', 'Cultivo creado exitosamente.');
    }

    public function show(Cultivo $cultivo)
    {
        $cultivo->load(['parcela', 'etapasFenologicas', 'laboresAgricolas', 'planesFertilizacion', 'controlesPlagas', 'planesCultivo', 'sistemasRiego', 'insumosAgricolas']);
        return view('cultivos.show', compact('cultivo'));
    }

    public function edit(Cultivo $cultivo)
    {
        $parcelas = Parcela::all();
        return view('cultivos.edit', compact('cultivo', 'parcelas'));
    }

    public function update(Request $request, Cultivo $cultivo)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'variedad' => 'nullable|string|max:255',
            'requerimientos' => 'nullable|string',
            'parcela_id' => 'required|exists:parcelas,id',
        ]);

        $cultivo->update($validated);

        return redirect()->route('cultivos.index')
            ->with('success', 'Cultivo actualizado exitosamente.');
    }

    public function destroy(Cultivo $cultivo)
    {
        // Check if cultivo has related records
        if ($cultivo->etapasFenologicas()->count() > 0 ||
            $cultivo->laboresAgricolas()->count() > 0 ||
            $cultivo->planesFertilizacion()->count() > 0 ||
            $cultivo->controlesPlagas()->count() > 0 ||
            $cultivo->planesCultivo()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el cultivo porque tiene registros asociados.');
        }

        $cultivo->delete();
        return redirect()->route('cultivos.index')
            ->with('success', 'Cultivo eliminado exitosamente.');
    }
}