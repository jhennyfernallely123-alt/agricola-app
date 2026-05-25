<?php

namespace App\Http\Controllers;

use App\Models\ControlPlagasEnfermedades;
use App\Models\Cultivo;
use Illuminate\Http\Request;

class ControlPlagasController extends Controller
{
    public function index()
    {
        $controles = ControlPlagasEnfermedades::with(['cultivo'])->get();
        return view('plagas.index', compact('controles'));
    }

    public function create()
    {
        $cultivos = Cultivo::all();
        return view('plagas.create', compact('cultivos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'tipo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'fecha_deteccion' => 'required|date',
            'tratamiento_aplicado' => 'nullable|string',
        ]);

        ControlPlagasEnfermedades::create($validated);

        return redirect()->route('plagas.index')
            ->with('success', 'Control de plagas creado exitosamente.');
    }

    public function show(ControlPlagasEnfermedades $control)
    {
        $control->load('cultivo');
        return view('plagas.show', compact('control'));
    }

    public function edit(ControlPlagasEnfermedades $control)
    {
        $cultivos = Cultivo::all();
        return view('plagas.edit', compact('control', 'cultivos'));
    }

    public function update(Request $request, ControlPlagasEnfermedades $control)
    {
        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'tipo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'fecha_deteccion' => 'required|date',
            'tratamiento_aplicado' => 'nullable|string',
        ]);

        $control->update($validated);

        return redirect()->route('plagas.index')
            ->with('success', 'Control de plagas actualizado exitosamente.');
    }

    public function destroy(ControlPlagasEnfermedades $control)
    {
        $control->delete();
        return redirect()->route('plagas.index')
            ->with('success', 'Control de plagas eliminado exitosamente.');
    }
}