@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-file-earmark-text"></i> Detalle de Factura</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="tarjeta-info">
                    <h3>Información de la Factura</h3>
                    <p><strong>ID:</strong> {{ $factura->id }}</p>
                    <p><strong>Número de Factura:</strong> {{ $factura->numero_factura }}</p>
                    <p><strong>Fecha de Emisión:</strong> {{ $factura->created_at->format('d/m/Y') }}</p>
                    <p><strong>Estado de Pago:</strong>
                        <span class="badge rounded-pill 
                            {{ $factura->estado_pago === 'pagado' ? 'bg-success' : 
                              ($factura->estado_pago === 'parcial' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                            {{ ucfirst($factura->estado_pago) }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tarjeta-info">
                    <h3>Información del Pedido</h3>
                    <p><strong>Pedido #:</strong> {{ $factura->pedido->id }}</p>
                    <p><strong>Cliente:</strong> {{ $factura->pedido->cliente->nombre }}</p>
                    <p><strong>Fecha del Pedido:</strong> {{ $factura->pedido->fecha }}</p>
                    <p><strong>Estado del Pedido:</strong>
                        <span class="badge rounded-pill 
                            {{ $factura->pedido->estado === 'entregado' ? 'bg-success' : 
                              ($factura->pedido->estado === 'enviado' ? 'bg-info' : 
                                ($factura->pedido->estado === 'en_proceso' ? 'bg-primary' : 
                                  ($factura->pedido->estado === 'pendiente' ? 'bg-secondary' : 'bg-danger'))) }}">
                            {{ ucfirst($factura->pedido->estado) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="tarjeta-info">
            <h3>Detalles Financieros</h3>
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Subtotal:</strong> ${{ number_format($factura->subtotal, 2) }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Total:</strong> ${{ number_format($factura->total, 2) }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>IVA (21%):</strong> ${{ number_format($factura->total - $factura->subtotal, 2) }}</p>
                </div>
            </div>
        </div>
        
        @if($factura->pagos->count() > 0)
        <div class="tarjeta-info">
            <h3>Historial de Pagos</h3>
            <table class="tabla-agricola">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Método de Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->pagos as $pago)
                    <tr>
                        <td>{{ $pago->fecha }}</td>
                        <td>${{ number_format($pago->monto, 2) }}</td>
                        <td>{{ $pago->metodo_pago ?? 'No especificado' }}</td>
                        <td>
                            <form action="{{ route('pagos.destroy', $pago) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este pago?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-accion btn-eliminar-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('facturas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver al Listado</a>
            @if($factura->estado_pago !== 'pagado')
            <a href="{{ route('pagos.create', ['factura_id' => $factura->id]) }}" class="btn btn-primary"><i class="bi bi-cash-coin"></i> Registrar Pago</a>
            @endif
        </div>
    </div>
</div>
@endsection