<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Transporte;
use App\Models\ProductoTerminado;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'transporte', 'productos'])->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $transportes = Transporte::all();
        $productos = ProductoTerminado::all();
        return view('pedidos.create', compact('clientes', 'transportes', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'estado' => 'required|in:pendiente,en_proceso,enviado,entregado,cancelado',
            'transporte_id' => 'nullable|exists:transportes,id',
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
        ]);

        $pedido = Pedido::create($validated);

        if ($request->has('productos')) {
            $pedido->productos()->attach($request->productos);
        }

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido creado exitosamente.');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'transporte', 'productos', 'factura', 'rutasEntrega']);
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $clientes = Cliente::all();
        $transportes = Transporte::all();
        $productos = ProductoTerminado::all();
        return view('pedidos.edit', compact('pedido', 'clientes', 'transportes', 'productos'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'estado' => ['required', Rule::in(['pendiente', 'en_proceso', 'enviado', 'entregado', 'cancelado'])],
            'transporte_id' => 'nullable|exists:transportes,id',
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
        ]);

        $pedido->update($validated);

        if ($request->has('productos')) {
            $pedido->productos()->sync($request->productos);
        } else {
            $pedido->productos()->detach();
        }

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido actualizado exitosamente.');
    }

    public function destroy(Pedido $pedido)
    {
        if ($pedido->estado === 'entregado') {
            return back()->with('error', 'No se puede eliminar un pedido entregado.');
        }
        
        $pedido->delete();
        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido eliminado exitosamente.');
    }

    public function updateEstado(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'estado' => ['required', Rule::in(['pendiente', 'en_proceso', 'enviado', 'entregado', 'cancelado'])],
        ]);

        if ($pedido->estado === 'entregado' && $validated['estado'] !== 'entregado') {
            return back()->with('error', 'No se puede cambiar el estado de un pedido entregado.');
        }

        $pedido->update(['estado' => $validated['estado']]);
        return redirect()->route('pedidos.index')
            ->with('success', 'Estado del pedido actualizado.');
    }
}