@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-cash-coin"></i> Detalle de Pago</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="tarjeta-info">
                    <h3>Información del Pago</h3>
                    <p><strong>ID:</strong> {{ $pago->id }}</p>
                    <p><strong>Monto:</strong> ${{ number_format($pago->monto, 2) }}</p>
                    <p><strong>Fecha:</strong> {{ $pago->fecha }}</p>
                    <p><strong>Método de Pago:</strong> {{ $pago->metodo_pago ?? 'No especificado' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tarjeta-info">
                    <h3>Información de la Factura</h3>
                    <p><strong>Factura #:</strong> {{ $pago->factura->numero_factura }}</p>
                    <p><strong>Pedido #:</strong> {{ $pago->factura->pedido->id }}</p>
                    <p><strong>Cliente:</strong> {{ $pago->factura->pedido->cliente->nombre }}</p>
                    <p><strong>Total Factura:</strong> ${{ number_format($pago->factura->total, 2) }}</p>
                    <p><strong>Saldo Pendiente:</strong> 
                        ${{ number_format($pago->factura->total - $pago->factura->pagos()->sum('monto'), 2) }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('pagos.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver al Listado</a>
            <a href="{{ route('pagos.edit', $pago) }}" class="btn btn-outline-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <form action="{{ route('pagos.destroy', $pago) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este pago?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection