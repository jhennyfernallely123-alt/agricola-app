@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-receipt"></i> Pedido #{{ $pedido->id }}</h1>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="p-3 rounded" style="background: #f0f7ee;">
                    <small class="text-muted"><i class="bi bi-people"></i> Cliente</small>
                    <p class="fw-bold mb-0">{{ $pedido->cliente->nombre ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 rounded" style="background: #f0f7ee;">
                    <small class="text-muted"><i class="bi bi-calendar"></i> Fecha</small>
                    <p class="fw-bold mb-0">{{ $pedido->fecha }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 rounded" style="background: #f0f7ee;">
                    <small class="text-muted"><i class="bi bi-flag"></i> Estado</small>
                    <p class="mb-0"><span class="estado-badge estado-{{ $pedido->estado }}">{{ $pedido->estado }}</span></p>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="p-3 rounded" style="background: #f0f7ee;">
                    <small class="text-muted"><i class="bi bi-truck"></i> Transporte</small>
                    <p class="fw-bold mb-0">{{ $pedido->transporte->placa ?? 'Sin asignar' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 rounded" style="background: #f0f7ee;">
                    <small class="text-muted"><i class="bi bi-box"></i> Productos</small>
                    @if($pedido->productos->count() > 0)
                        <p class="fw-bold mb-0">{{ $pedido->productos->count() }} producto(s)</p>
                    @else
                        <p class="mb-0 text-muted">Sin productos</p>
                    @endif
                </div>
            </div>
        </div>

        @if($pedido->productos->count() > 0)
        <h3 class="mt-4"><i class="bi bi-box-seam"></i> Productos del Pedido</h3>
        <table class="tabla-agricola mt-2">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Lote</th>
                    <th>Calidad</th>
                    <th>Presentación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedido->productos as $producto)
                <tr>
                    <td><strong>{{ $producto->nombre }}</strong></td>
                    <td>{{ $producto->lote }}</td>
                    <td>{{ $producto->calidad ?? 'N/A' }}</td>
                    <td>{{ $producto->presentacion ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        @if($pedido->factura)
        <div class="mt-4 p-3 rounded" style="background: #fff8e1; border-left: 4px solid var(--marron-claro);">
            <h5><i class="bi bi-file-text"></i> Factura #{{ $pedido->factura->numero_factura }}</h5>
            <p class="mb-0"><strong>Total:</strong> ${{ number_format($pedido->factura->total, 2) }}</p>
        </div>
        @endif

        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
            <a href="{{ route('pedidos.edit', $pedido) }}" class="btn-accion btn-editar"><i class="bi bi-pencil"></i> Editar</a>
        </div>
    </div>
</div>
@endsection
