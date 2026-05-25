<?php

namespace App\Http\Controllers;

use App\Models\SistemaRiego;
use Illuminate\Http\Request;

class SistemaRiegoController extends Controller
{
    public function index()
    {
        $sistemas = SistemaRiego::withCount('cultivos')->get();
        return view('sistemas_riego.index', compact('sistemas'));
    }

    public function create()
    {
        return view('sistemas_riego.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'fuente' => 'nullable|string|max:255',
        ]);

        SistemaRiego::create($validated);

        return redirect()->route('sistemas-riego.index')
            ->with('success', 'Sistema de riego creado exitosamente.');
    }

    public function show(SistemaRiego $sistema)
    {
        $sistema->load('cultivos');
        return view('sistemas_riego.show', compact('sistema'));
    }

    public function edit(SistemaRiego $sistema)
    {
        return view('sistemas_riego.edit', compact('sistema'));
    }

    public function update(Request $request, SistemaRiego $sistema)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'fuente' => 'nullable|string|max:255',
        ]);

        $sistema->update($validated);

        return redirect()->route('sistemas-riego.index')
            ->with('success', 'Sistema de riego actualizado exitosamente.');
    }

    public function destroy(SistemaRiego $sistema)
    {
        if ($sistema->cultivos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el sistema de riego porque tiene cultivos asociados.');
        }

        $sistema->delete();
        return redirect()->route('sistemas-riego.index')
            ->with('success', 'Sistema de riego eliminado exitosamente.');
    }
}