<?php

namespace App\Http\Controllers;

use App\Models\InsumoAgricola;
use Illuminate\Http\Request;

class FertilizanteController extends Controller
{
    public function index()
    {
        $fertilizantes = InsumoAgricola::withCount('cultivos')->get();
        return view('fertilizantes.index', compact('fertilizantes'));
    }

    public function create()
    {
        return view('fertilizantes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        InsumoAgricola::create($validated);

        return redirect()->route('fertilizantes.index')
            ->with('success', 'Fertilizante creado exitosamente.');
    }

    public function show(InsumoAgricola $fertilizante)
    {
        $fertilizante->load('cultivos');
        return view('fertilizantes.show', compact('fertilizante'));
    }

    public function edit(InsumoAgricola $fertilizante)
    {
        return view('fertilizantes.edit', compact('fertilizante'));
    }

    public function update(Request $request, InsumoAgricola $fertilizante)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $fertilizante->update($validated);

        return redirect()->route('fertilizantes.index')
            ->with('success', 'Fertilizante actualizado exitosamente.');
    }

    public function destroy(InsumoAgricola $fertilizante)
    {
        if ($fertilizante->cultivos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el fertilizante porque tiene cultivos asociados.');
        }

        $fertilizante->delete();
        return redirect()->route('fertilizantes.index')
            ->with('success', 'Fertilizante eliminado exitosamente.');
    }
}