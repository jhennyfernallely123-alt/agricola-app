<?php

namespace App\Http\Controllers;

use App\Models\Transporte;
use Illuminate\Http\Request;

class TransporteController extends Controller
{
    public function index()
    {
        $transportes = Transporte::withCount('pedidos')->get();
        return view('transportes.index', compact('transportes'));
    }

    public function create()
    {
        return view('transportes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'placa' => 'nullable|string|max:20|unique:transportes,placa',
            'capacidad' => 'nullable|integer|min:1',
        ]);

        Transporte::create($validated);

        return redirect()->route('transportes.index')
            ->with('success', 'Transporte creado exitosamente.');
    }

    public function show(Transporte $transporte)
    {
        $transporte->load('pedidos.cliente');
        return view('transportes.show', compact('transporte'));
    }

    public function edit(Transporte $transporte)
    {
        return view('transportes.edit', compact('transporte'));
    }

    public function update(Request $request, Transporte $transporte)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'placa' => 'nullable|string|max:20|unique:transportes,placa,'.$transporte->id,
            'capacidad' => 'nullable|integer|min:1',
        ]);

        $transporte->update($validated);

        return redirect()->route('transportes.index')
            ->with('success', 'Transporte actualizado exitosamente.');
    }

    public function destroy(Transporte $transporte)
    {
        if ($transporte->pedidos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el transporte porque tiene pedidos asociados.');
        }

        $transporte->delete();
        return redirect()->route('transportes.index')
            ->with('success', 'Transporte eliminado exitosamente.');
    }
}