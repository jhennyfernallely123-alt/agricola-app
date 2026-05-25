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
        $productos = ProductoTerminado::with('inventario')->get();
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
            'cantidades' => 'nullable|array',
            'cantidades.*' => 'numeric|min:0',
        ]);

        $pedido = Pedido::create($validated);

        if ($request->has('productos')) {
            $pivotData = [];
            foreach ($request->productos as $productoId) {
                $cantidad = $request->cantidades[$productoId] ?? 0;

                // Validar stock
                $inventario = \App\Models\InventarioProductos::where('producto_id', $productoId)->first();
                if ($inventario && $cantidad > $inventario->cantidad_disponible) {
                    $producto = \App\Models\ProductoTerminado::find($productoId);
                    return back()->withInput()
                        ->withErrors(['productos' => "Stock insuficiente para {$producto->nombre}. Disponible: {$inventario->cantidad_disponible} kg, solicitado: {$cantidad} kg."]);
                }

                $pivotData[$productoId] = ['cantidad' => $cantidad];
            }
            $pedido->productos()->attach($pivotData);
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
        $productos = ProductoTerminado::with('inventario')->get();
        $pedido->load(['productos' => fn($q) => $q->withPivot('cantidad')]);
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
            'cantidades' => 'nullable|array',
            'cantidades.*' => 'numeric|min:0',
        ]);

        $pedido->update($validated);

        if ($request->has('productos')) {
            $pivotData = [];
            foreach ($request->productos as $productoId) {
                $cantidad = $request->cantidades[$productoId] ?? 0;

                // Validar stock (solo si aumentó respecto a lo que ya tenía)
                $originalCantidad = $pedido->productos()
                    ->wherePivot('producto_id', $productoId)
                    ->first()?->pivot->cantidad ?? 0;

                if ($cantidad > $originalCantidad) {
                    $inventario = \App\Models\InventarioProductos::where('producto_id', $productoId)->first();
                    $stockRestante = ($inventario?->cantidad_disponible ?? 0) + $originalCantidad;
                    if ($cantidad > $stockRestante) {
                        $producto = \App\Models\ProductoTerminado::find($productoId);
                        return back()->withInput()
                            ->withErrors(['productos' => "Stock insuficiente para {$producto->nombre}. Disponible: {$stockRestante} kg, solicitado: {$cantidad} kg."]);
                    }
                }

                $pivotData[$productoId] = ['cantidad' => $cantidad];
            }
            $pedido->productos()->sync($pivotData);
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